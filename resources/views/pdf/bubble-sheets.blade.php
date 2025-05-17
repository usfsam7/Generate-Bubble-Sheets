@foreach ($students as $student)
<div style="page-break-after: always; font-family: 'DejaVu Sans'; padding: 40px;">
    <h2>Bubble Sheet</h2>
    <p><strong>الاسم:</strong> {{ $student['name'] }}</p>
    <p><strong>البرنامج:</strong> {{ $student['program'] }}</p>
    <p><strong>المقرر:</strong> {{ $student['course'] }}</p>
    <p><strong>المستوي:</strong> {{ $student['level'] }}</p>
    <p><strong>الرقم الاكاديمي:</strong> {{ $student['academic_number'] }}</p>
</div>
@endforeach
