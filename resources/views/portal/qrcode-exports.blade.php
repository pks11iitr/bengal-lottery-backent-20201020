<table>
    <thead>
    <tr>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
    @for($i=$start; $i<$end; $i++)
        <tr>
            <td>{{ $i }}</td>
        </tr>
    @endfor
    </tbody>
</table>
