<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageKitService;

class ReelController extends Controller
{
    public function index()
    {
        $reels = DB::table('reels')
            ->leftJoin('products', 'products.id', '=', 'reels.product_id')
            ->select('reels.*', 'products.name as product_name', 'products.slug as product_slug')
            ->orderBy('reels.sort_order', 'asc')
            ->orderBy('reels.id', 'desc')
            ->get();

        return view('admin.pages.reels.list', compact('reels'));
    }

    public function create()
    {
        $products = DB::table('products')
            ->where('is_deleted', 0)
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'slug']);
        return view('admin.pages.reels.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_file' => 'nullable|file|mimes:mp4,webm,mov,avi|max:102400', // 100MB max
            'product_id' => 'nullable|integer|exists:products,id',
            'views'      => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        // Fetch existing for update
        $existing   = $request->id ? DB::table('reels')->where('id', $request->id)->first() : null;
        $videoUrl   = $existing->video_url            ?? null;
        $ikFileId   = $existing->imagekit_file_id_video ?? null;

        if ($request->hasFile('video_file')) {
            $imagekitService = new ImageKitService();

            if ($imagekitService->isEnabled()) {
                // Upload to ImageKit
                $result = $imagekitService->uploadVideo(
                    $request->file('video_file'),
                    'reels'
                );

                if ($result && $result['success']) {
                    // Delete old video from ImageKit
                    if ($ikFileId) {
                        $imagekitService->deleteImage($ikFileId);
                    }
                    $videoUrl = $result['url'];
                    $ikFileId = $result['file_id'];
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Video upload to ImageKit failed. Check logs.'], 500);
                }
            } else {
                // Local fallback
                $file     = $request->file('video_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/reels'), $fileName);
                $videoUrl = url('uploads/reels/' . $fileName);
                $ikFileId = null;
            }
        }

        $data = [
            'video_url'              => $videoUrl,
            'imagekit_file_id_video' => $ikFileId,
            'views'                  => $request->views ?? 0,
            'product_id'             => $request->product_id ?: null,
            'sort_order'             => $request->sort_order ?? 0,
            'is_active'              => 1,
            'platform'               => 'direct_video',
            'reel_url'               => null,
            'updated_at'             => now(),
        ];

        if ($request->id) {
            DB::table('reels')->where('id', $request->id)->update($data);
            $message = 'Reel updated successfully!';
        } else {
            $data['created_at'] = now();
            DB::table('reels')->insert($data);
            $message = 'Reel added successfully!';
        }

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function edit($id)
    {
        $reel = DB::table('reels')->where('id', $id)->first();
        if (!$reel) {
            return redirect()->route('reels.index')->with('error', 'Reel not found.');
        }
        $products = DB::table('products')
            ->where('is_deleted', 0)
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'slug']);
        return view('admin.pages.reels.create', compact('reel', 'products'));
    }

    public function toggleActive(Request $request)
    {
        $reel = DB::table('reels')->where('id', $request->id)->first();
        if (!$reel) {
            return response()->json(['success' => false, 'message' => 'Not found.']);
        }
        $new = $reel->is_active ? 0 : 1;
        DB::table('reels')->where('id', $request->id)->update(['is_active' => $new]);
        return response()->json(['success' => true, 'is_active' => $new]);
    }

    public function destroy($id)
    {
        $reel = DB::table('reels')->where('id', $id)->first();
        if ($reel && $reel->imagekit_file_id_video) {
            $imagekitService = new ImageKitService();
            if ($imagekitService->isEnabled()) {
                $imagekitService->deleteImage($reel->imagekit_file_id_video);
            }
        }
        DB::table('reels')->where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => 'Reel deleted successfully.']);
    }
}
