<div class="table-container">
    <table class="contacts-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 18%;">Name</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 15%;">Phone</th>
                <th style="width: 25%;">Subject</th>
                <th style="width: 12%;">Date</th>
                <th style="width: 5%;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $key => $contact)
            <tr data-id="{{ $contact->id }}">
                <td>{{ $contacts->firstItem() + $key }}</td>
                <td>
                    <div class="contact-name">
                        <iconify-icon icon="solar:user-bold" class="name-icon"></iconify-icon>
                        <span>{{ $contact->name }}</span>
                    </div>
                </td>
                <td>
                    <div class="contact-email">
                        <iconify-icon icon="solar:letter-bold" class="email-icon"></iconify-icon>
                        <span>{{ $contact->email }}</span>
                    </div>
                </td>
                <td>
                    <div class="contact-phone">
                        <iconify-icon icon="solar:phone-bold" class="phone-icon"></iconify-icon>
                        <span>{{ $contact->phone ?? 'N/A' }}</span>
                    </div>
                </td>
                <td>
                    <span class="contact-subject">{{ $contact->subject }}</span>
                </td>
                <td>
                    <div class="contact-date">
                        <iconify-icon icon="solar:calendar-bold" class="date-icon"></iconify-icon>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <span style="font-weight: 600;">
                                @if(isset($contact->created_at))
                                    {{ \Carbon\Carbon::parse($contact->created_at)->format('d M Y') }}
                                @elseif(isset($contact->date))
                                    {{ \Carbon\Carbon::parse($contact->date)->format('d M Y') }}
                                @else
                                    N/A
                                @endif
                            </span>
                            <span style="font-size: 0.75rem; color: #95a5a6;">
                                @if(isset($contact->created_at))
                                    {{ \Carbon\Carbon::parse($contact->created_at)->format('h:i A') }}
                                @elseif(isset($contact->date))
                                    {{ \Carbon\Carbon::parse($contact->date)->format('h:i A') }}
                                @endif
                            </span>
                        </div>
                    </div>
                </td>
                <td>
                    <button class="btn-view-details" data-id="{{ $contact->id }}" data-name="{{ $contact->name }}" data-email="{{ $contact->email }}" data-phone="{{ $contact->phone ?? 'N/A' }}" data-subject="{{ $contact->subject }}" data-message="{{ $contact->message ?? 'No message' }}">
                        <iconify-icon icon="solar:eye-bold"></iconify-icon>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 3rem; color: #7f8c8d;">
                    <iconify-icon icon="solar:inbox-line-broken" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></iconify-icon>
                    <p style="margin: 0; font-size: 1rem; font-weight: 600;">No contact queries found</p>
                    <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem;">Try adjusting your search filters</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
