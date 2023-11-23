@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://i.pinimg.com/originals/55/08/ca/5508ca788ef298f0d8d034d613529411.png" class="logo" alt="Company Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
