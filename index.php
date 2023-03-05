<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <title>Data Tables</title>
</head>
<body>
    <h1>Listar usuários</h1>
    <table id="list" class="display" style="width:100%">
        <thead>
            <tr>
                <th>CRM</th>
                <th>Nome Completo</th>
                <th>Salario</th>
            </tr>
        </thead>
    </table>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
        $('#list').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "listUsers.php",
            "language":{ 
                "url": "//cdn.datatables.net/plug-ins/1.13.3/i18n/pt-BR.json"
                }
            });
        });

        $.fn.dataTable.ext.errMode = 'throw';
    </script>
</body>
</html>