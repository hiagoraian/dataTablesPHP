<?php 
   include_once './server.php';
   
    $dados_request = $_REQUEST;


    //Lista de colunas na tabela
    $colunas = [
        0 => 'crm',
        1 => 'name',
        2 => 'salary'
    ];




    $query_qnt_users = "SELECT COUNT(crm) AS qnt_users FROM $dbName.users";
    //Paginação no filtro de pesquisa
    if(!empty($dados_request['search']['value'])){
        $query_qnt_users .= " WHERE crm LIKE :crm ";
        $query_qnt_users .= " OR name LIKE :name ";
        $query_qnt_users .= " OR salary LIKE :salary ";

    }

    $result_qnt_users = $conn->prepare($query_qnt_users);

    if(!empty($dados_request['search']['value'])){
        $valor_pesquisar = "%" . $dados_request['search']['value'] . "%";
        $result_qnt_users->bindParam(':crm' ,$valor_pesquisar , PDO::PARAM_STR);
        $result_qnt_users->bindParam(':name' ,$valor_pesquisar , PDO::PARAM_STR);
        $result_qnt_users->bindParam(':salary' ,$valor_pesquisar , PDO::PARAM_STR);
    }
    $result_qnt_users->execute();

    $row_qnt_users = $result_qnt_users->fetch(PDO::FETCH_ASSOC); 
    //var_dump($row_qnt_users);

    /*$query_list_users = "SELECT crm, name, salary FROM $dbName.users ORDER BY crm ASC LIMIT :inicio, :quantidade";*/

    $query_list_users = "SELECT crm, name, salary FROM $dbName.users ";

    //Acessar if quando ha parametros de pesquisa.

    if(!empty($dados_request['search']['value'])){
        $query_list_users .= " WHERE crm LIKE :crm ";
        $query_list_users .= " OR name LIKE :name ";
        $query_list_users .= " OR salary LIKE :salary ";

    }


    $query_list_users .=" ORDER BY " .$colunas[$dados_request['order'][0]['column']] . " " . $dados_request['order'][0]['dir'] . " LIMIT :inicio, :quantidade";

    $result_list_users = $conn->prepare($query_list_users);
    $result_list_users->bindParam(':inicio', $dados_request['start'],PDO::PARAM_INT);
    $result_list_users->bindParam(':quantidade', $dados_request['length'], PDO::PARAM_INT);


    
    if(!empty($dados_request['search']['value'])){
        $valor_pesquisar = "%" . $dados_request['search']['value'] . "%";
        $result_list_users->bindParam(':crm' ,$valor_pesquisar , PDO::PARAM_STR);
        $result_list_users->bindParam(':name' ,$valor_pesquisar , PDO::PARAM_STR);
        $result_list_users->bindParam(':salary' ,$valor_pesquisar , PDO::PARAM_STR);
    }

    //Executar a query
    $result_list_users->execute();

    while($row_users = $result_list_users->fetch(PDO::FETCH_ASSOC)){
        
        extract($row_users);
        $record = [];
        $record[] = $crm;
        $record[] = $name;
        $record[] = $salary;

        $dados[] = $record;
    }
    
    $result = [
        "draw" => intval($dados_request['draw']),
        "recordsTotal" => intval($row_qnt_users['qnt_users']),
        "recordsFiltered" => intval($row_qnt_users['qnt_users']),
        "data" => $dados
    ];
    echo json_encode($result);
?> 