@extends('admin.main.app')
@section('admin-title', 'Dashboard')
@section('topbar-text', 'Dashboard')

@section('admin-css')
<style>
/* ===== DASHBOARD ===== */
.dash-wrap { padding: 28px 24px 24px; }

/* ── Stat Cards ── */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}
@media(max-width:1199px){ .stat-grid{ grid-template-columns: repeat(2,1fr); } }
@media(max-width:575px) { .stat-grid{ grid-template-columns: 1fr; } }

.stat-card {
    border-radius: 16px;
    padding: 22px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: transform 0.25s, box-shadow 0.25s;
}
.stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(0,0,0,0.13); }

.stat-card.c1 { background: linear-gradient(135deg,#6366f1,#818cf8); }
.stat-card.c2 { background: linear-gradient(135deg,#10b981,#34d399); }
.stat-card.c3 { background: linear-gradient(135deg,#f59e0b,#fbbf24); }
.stat-card.c4 { background: linear-gradient(135deg,#ef4444,#f87171); }
.stat-card.c5 { background: linear-gradient(135deg,#8b5cf6,#a78bfa); }
.stat-card.c6 { background: linear-gradient(135deg,#06b6d4,#22d3ee); }
.stat-card.c7 { background: linear-gradient(135deg,#ec4899,#f472b6); }
.stat-card.c8 { background: linear-gradient(135deg,#14b8a6,#2dd4bf); }

.stat-icon-wrap {
    width: 56px; height: 56px;
    border-radius: 14px;
    background: rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.stat-icon-wrap svg { color: #fff; }

.stat-info { flex: 1; min-width: 0; }
.stat-val {
    font-size: 1.75rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    margin-bottom: 4px;
}
.stat-lbl {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.85);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.stat-badge {
    position: absolute;
    top: 14px; right: 14px;
    background: rgba(255,255,255,0.2);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 20px;
}

/* ── Panels ── */
.dash-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 24px;
}
@media(max-width:991px){ .dash-row{ grid-template-columns: 1fr; } }

.dash-panel {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    overflow: hidden;
}
.dash-panel-full {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    overflow: hidden;
    margin-bottom: 24px;
}

.panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px 14px;
    border-bottom: 1px solid #f1f5f9;
}
.panel-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
}
.panel-title .dot {
    width: 8px; height: 8px;
    border-radius: 50%;
}
.panel-link {
    font-size: 0.78rem;
    color: #6366f1;
    text-decoration: none;
    font-weight: 600;
}
.panel-link:hover { text-decoration: underline; }

/* ── Order Status Row ── */
.order-status-grid {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: 0;
}
@media(max-width:575px){ .order-status-grid{ grid-template-columns: repeat(2,1fr); } }

.os-item {
    padding: 20px 16px;
    text-align: center;
    border-right: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
}
.os-item:nth-child(4n) { border-right: none; }
.os-num {
    font-size: 1.6rem;
    font-weight: 800;
    margin-bottom: 4px;
}
.os-lbl { font-size: 0.75rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; }

/* ── Recent Orders Table ── */
.dash-table { width: 100%; border-collapse: collapse; }
.dash-table th {
    background: #f8fafc;
    color: #64748b;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 10px 16px;
    text-align: left;
    border-bottom: 1px solid #f1f5f9;
}
.dash-table td {
    padding: 12px 16px;
    font-size: 0.85rem;
    color: #374151;
    border-bottom: 1px solid #f8fafc;
    vertical-align: middle;
}
.dash-table tr:last-child td { border-bottom: none; }
.dash-table tr:hover td { background: #fafbfc; }

.order-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 700;
}
.badge-pending   { background: #fef3c7; color: #d97706; }
.badge-confirmed { background: #dbeafe; color: #2563eb; }
.badge-delivered { background: #d1fae5; color: #059669; }
.badge-cancelled { background: #fee2e2; color: #dc2626; }

/* ── Top Products ── */
.top-prod-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 20px;
    border-bottom: 1px solid #f8fafc;
    transition: background 0.15s;
}
.top-prod-item:last-child { border-bottom: none; }
.top-prod-item:hover { background: #fafbfc; }
.top-prod-rank {
    width: 28px; height: 28px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem;
    font-weight: 800;
    flex-shrink: 0;
}
.rank-1 { background: #fef3c7; color: #d97706; }
.rank-2 { background: #f1f5f9; color: #64748b; }
.rank-3 { background: #fce7f3; color: #db2777; }
.rank-4, .rank-5 { background: #f0fdf4; color: #16a34a; }

.top-prod-name { flex: 1; font-size: 0.85rem; font-weight: 600; color: #1e293b; }
.top-prod-sold { font-size: 0.8rem; color: #6366f1; font-weight: 700; }

/* ── Revenue Chart ── */
.chart-wrap { padding: 16px 20px 20px; }
canvas { max-height: 220px; }

/* ── Quick Actions ── */
.quick-grid {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap: 12px;
    padding: 16px 20px;
}
@media(max-width:575px){ .quick-grid{ grid-template-columns: repeat(2,1fr); } }

.quick-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 16px 8px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 0.78rem;
    font-weight: 600;
    color: #374151;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    transition: all 0.2s;
    text-align: center;
}
.quick-btn:hover { background: #6366f1; color: #fff; border-color: #6366f1; transform: translateY(-2px); }
.quick-btn:hover svg { color: #fff; }
.quick-btn svg { color: #6366f1; transition: color 0.2s; }
</style>
@endsection

@section('admin-content')
<div class="dash-wrap">

    {{-- ── STAT CARDS ── --}}
    <div class="stat-grid">

        <div class="stat-card c1">
            <div class="stat-icon-wrap">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-val">{{ number_format($products) }}</div>
                <div class="stat-lbl">Total Products</div>
            </div>
            <span class="stat-badge">Live</span>
        </div>

        <div class="stat-card c2">
            <div class="stat-icon-wrap">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-val">{{ number_format($total_orders) }}</div>
                <div class="stat-lbl">Total Orders</div>
            </div>
            <span class="stat-badge">All</span>
        </div>

        <div class="stat-card c3">
            <div class="stat-icon-wrap">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <text x="4" y="18" font-size="16" font-weight="bold" fill="currentColor" stroke="none" font-family="Arial">₹</text>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-val">₹{{ number_format($total_revenue) }}</div>
                <div class="stat-lbl">Total Revenue</div>
            </div>
            <span class="stat-badge">Delivered</span>
        </div>

        <div class="stat-card c4">
            <div class="stat-icon-wrap">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-val">{{ number_format($users) }}</div>
                <div class="stat-lbl">Customers</div>
            </div>
            <span class="stat-badge">Registered</span>
        </div>

        <div class="stat-card c5">
            <div class="stat-icon-wrap">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-val">{{ number_format($pending_orders) }}</div>
                <div class="stat-lbl">Pending Orders</div>
            </div>
            <span class="stat-badge">Action</span>
        </div>

        <div class="stat-card c6">
            <div class="stat-icon-wrap">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-val">{{ number_format($ongoing_orders) }}</div>
                <div class="stat-lbl">Ongoing Orders</div>
            </div>
            <span class="stat-badge">Active</span>
        </div>

        <div class="stat-card c7">
            <div class="stat-icon-wrap">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-val">{{ number_format($completed_orders) }}</div>
                <div class="stat-lbl">Delivered</div>
            </div>
            <span class="stat-badge">Done</span>
        </div>

        <div class="stat-card c8">
            <div class="stat-icon-wrap">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-val">{{ number_format($brands) }}</div>
                <div class="stat-lbl">Brands</div>
            </div>
            <span class="stat-badge">Active</span>
        </div>

    </div>

    {{-- ── ORDER STATUS + QUICK ACTIONS ── --}}
    <div class="dash-row">

        {{-- Order Status --}}
        <div class="dash-panel">
            <div class="panel-head">
                <div class="panel-title">
                    <span class="dot" style="background:#6366f1;"></span>
                    Order Status Overview
                </div>
                <a href="{{ route('orders.index') }}" class="panel-link">View All →</a>
            </div>
            <div class="order-status-grid">
                <div class="os-item">
                    <div class="os-num" style="color:#f59e0b;">{{ $pending_orders }}</div>
                    <div class="os-lbl">Pending</div>
                </div>
                <div class="os-item">
                    <div class="os-num" style="color:#3b82f6;">{{ $ongoing_orders }}</div>
                    <div class="os-lbl">Ongoing</div>
                </div>
                <div class="os-item">
                    <div class="os-num" style="color:#10b981;">{{ $completed_orders }}</div>
                    <div class="os-lbl">Delivered</div>
                </div>
                <div class="os-item" style="border-right:none;">
                    <div class="os-num" style="color:#ef4444;">{{ $cancelled_orders }}</div>
                    <div class="os-lbl">Cancelled</div>
                </div>
            </div>
            {{-- Revenue mini chart --}}
            <div class="chart-wrap">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="dash-panel">
            <div class="panel-head">
                <div class="panel-title">
                    <span class="dot" style="background:#10b981;"></span>
                    Quick Actions
                </div>
            </div>
            <div class="quick-grid">
                <a href="{{ route('product.create') }}" class="quick-btn">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                    Add Product
                </a>
                <a href="{{ route('banner.create') }}" class="quick-btn">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Add Banner
                </a>
                <a href="{{ route('category.create') }}" class="quick-btn">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h8m-8 6h16"/></svg>
                    Add Category
                </a>
                <a href="{{ route('collections.create') }}" class="quick-btn">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    Add Collection
                </a>
                <a href="{{ route('coupon.create') }}" class="quick-btn">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    Add Coupon
                </a>
                <a href="{{ route('reels.create') }}" class="quick-btn">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                    Add Reel
                </a>
            </div>
        </div>

    </div>

    {{-- ── RECENT ORDERS + TOP PRODUCTS ── --}}
    <div class="dash-row">

        {{-- Recent Orders --}}
        <div class="dash-panel">
            <div class="panel-head">
                <div class="panel-title">
                    <span class="dot" style="background:#f59e0b;"></span>
                    Recent Orders
                </div>
                <a href="{{ route('orders.index') }}" class="panel-link">View All →</a>
            </div>
            <div style="overflow-x:auto;">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_orders as $order)
                        <tr>
                            <td style="font-weight:700; color:#6366f1;">#{{ $order->custom_order_id ?? $order->id }}</td>
                            <td>
                                <div style="font-weight:600; color:#1e293b;">{{ Str::limit($order->customer_name, 18) }}</div>
                                <div style="font-size:0.72rem; color:#94a3b8;">{{ Str::limit($order->customer_email, 22) }}</div>
                            </td>
                            <td style="font-weight:700;">₹{{ number_format($order->total_amount) }}</td>
                            <td>
                                @if($order->is_cancel)
                                    <span class="order-badge badge-cancelled">Cancelled</span>
                                @elseif($order->is_deliverd)
                                    <span class="order-badge badge-delivered">Delivered</span>
                                @elseif($order->is_confirm)
                                    <span class="order-badge badge-confirmed">Confirmed</span>
                                @else
                                    <span class="order-badge badge-pending">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center; color:#94a3b8; padding:24px;">No orders yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Products --}}
        <div class="dash-panel">
            <div class="panel-head">
                <div class="panel-title">
                    <span class="dot" style="background:#ec4899;"></span>
                    Top Selling Products
                </div>
                <a href="{{ route('product.index') }}" class="panel-link">View All →</a>
            </div>
            @forelse($top_products as $i => $prod)
            <div class="top-prod-item">
                <div class="top-prod-rank rank-{{ $i+1 }}">{{ $i+1 }}</div>
                <div class="top-prod-name">{{ Str::limit($prod->name, 30) }}</div>
                <div class="top-prod-sold">{{ $prod->total_sold }} sold</div>
            </div>
            @empty
            <div style="padding:24px; text-align:center; color:#94a3b8;">No sales data yet</div>
            @endforelse
        </div>

    </div>

</div>
@endsection

@section('admin-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
    var ctx = document.getElementById('revenueChart');
    if (!ctx) return;

    // Last 7 delivered orders revenue
    var labels = @json($weekly_sales->reverse()->values()->map(fn($o,$i) => 'Order '.($i+1)));
    var data   = @json($weekly_sales->reverse()->values()->pluck('total_amount'));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue (₹)',
                data: data,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#6366f1',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) { return ' ₹' + Number(ctx.raw).toLocaleString('en-IN'); }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                y: {
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { size: 10 },
                        callback: function(v) { return '₹' + (v/1000).toFixed(0) + 'k'; }
                    }
                }
            }
        }
    });
})();
</script>
@endsection
