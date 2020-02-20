  <?php
    set_time_limit(0);
    ini_set("memory_limit",'2024M'); // ini_set('memory_limit', '2024M'); // or you could use 1G
    ini_set('max_execution_time', 0);
  ?>


  {{ dd($response) }}


<table>
    <thead>
    <tr>
        <th>Folio</th>
        <th>Recomendación</th>
        <th>Año de registro</th>
        <th>Entidad emisora</th>
        <th>Orden de Gobierno</th>
        <th>Poder de Gobierno</th>
        <th>Autoridad</th>
        <th>Poblaci&oacute;n</th>
        <th>Acci&oacute;n Solicitada</th>
        <th>ODS</th>
        <th>Derechos Humanos</th>
        <th>Temas</th>
        <th>Comentarios</th>
    </tr>
    </thead>
    <tbody>

    @foreach($response as $value)
        <tr>
            {{-- <td>{{ $value->invoice }}</td> --}}
            <td>{{ $value->recommendation }}</td>
            <td>{{ $value->date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
