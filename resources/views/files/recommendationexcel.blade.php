<table>
    <thead>
    <tr>
        <th>Recomendación</th>
        <th>Entidad Emisora</th>
    </tr>
    </thead>
    <tbody>
    @foreach($response as $value)
        <tr>
            <td>{{ $value->recommendation }}</td>
            <td>{{ $value->cat_entity_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
