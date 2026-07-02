@extends('layouts.admin')
@section('title', 'مقالات و داوری')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;"><i class="ti ti-file-text"></i> مدیریت مقالات و داوری</h1>

<form method="GET" style="display:flex; gap:.75rem; margin-bottom:1.25rem;">
    <select name="track" class="form-control" style="width:auto;" onchange="this.form.submit()">
        <option value="">همه محورها</option>
        <option value="instrumentation" {{ request('track')=='instrumentation'?'selected':'' }}>ابزار دقیق</option>
        <option value="mechanical" {{ request('track')=='mechanical'?'selected':'' }}>تاسیسات مکانیکی</option>
        <option value="electrical" {{ request('track')=='electrical'?'selected':'' }}>برق صنعتی</option>
        <option value="innovation" {{ request('track')=='innovation'?'selected':'' }}>نوآوری</option>
    </select>
    <select name="status" class="form-control" style="width:auto;" onchange="this.form.submit()">
        <option value="">همه وضعیت‌ها</option>
        <option value="submitted" {{ request('status')=='submitted'?'selected':'' }}>ارسال شده</option>
        <option value="under_review" {{ request('status')=='under_review'?'selected':'' }}>در حال داوری</option>
        <option value="accepted" {{ request('status')=='accepted'?'selected':'' }}>پذیرفته</option>
        <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>رد شده</option>
        <option value="revision" {{ request('status')=='revision'?'selected':'' }}>نیاز به اصلاح</option>
    </select>
</form>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>عنوان</th><th>نویسنده</th><th>محور</th><th>امتیاز میانگین</th><th>وضعیت</th><th>تخصیص داور</th></tr></thead>
            <tbody>
                @forelse($papers as $p)
                <tr>
                    <td>{{ Str::limit($p->title, 35) }}</td>
                    <td>{{ $p->author->name ?? '—' }}</td>
                    <td>{{ $p->track_label }}</td>
                    <td>{{ $p->average_score ?: '—' }}</td>
                    <td><span class="badge badge-primary">{{ $p->status_label }}</span></td>
                    <td>
                        <form action="{{ route('admin.conference.assign', $p->id) }}" method="POST" style="display:flex; gap:.4rem;">
                            @csrf
                            <select name="judge_id" class="form-control" style="width:auto;" required>
    <option value="">-- انتخاب داور --</option>
    @foreach($judges as $j)
    <option value="{{ $j->user_id }}">{{ $j->name }}</option>
    @endforeach
</select>
                            <button type="submit" class="btn btn-sm btn-primary">تخصیص</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">مقاله‌ای ارسال نشده است</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-2">{{ $papers->links() }}</div>
@endsection
