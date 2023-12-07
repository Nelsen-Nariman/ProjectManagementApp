@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Mydealer')
<h1 class="font-black text-3xl mt-10">Mydealer</h1>
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
