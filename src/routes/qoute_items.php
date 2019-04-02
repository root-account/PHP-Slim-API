<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


// add new Qoute Item
$app->post('/api/qoutations/additem/{qoute_no}', function(Request $request, Response $response)
{
    // Get id from url
    $qoute_no = $request->getAttribute('qoute_no');

    $item_name = $request->getParam('item_name');
    $item_desc = $request->getParam('item_desc');
    $item_price = $request->getParam('item_price');
    $item_rate_ph = $request->getParam('item_rate_ph');
    $item_duration = $request->getParam('item_duration');
    $quantity = $request->getParam('quantity');

    // The query
    $qry = "
        INSERT INTO qoute_items (
            qoute_no,
            item_name,
            item_desc,
            item_price,
            item_rate_ph,
            item_duration,
            quantity
        )VALUES(
            :qoute_no,
            :item_name,
            :item_desc,
            :item_price,
            :item_rate_ph,
            :item_duration,
            :quantity
        )
    ";

    try{
        // Create db connect object
        $db = new db_con();

        //Call the connect method
        $db = $db->connect();

        // Prepare the statement
        $stmt = $db->prepare($qry);

        // Bind values to parameters
        $stmt->bindParam(':qoute_no', $qoute_no);
        $stmt->bindParam(':item_name', $item_name);
        $stmt->bindParam(':item_desc', $item_desc);
        $stmt->bindParam(':item_price', $item_price);
        $stmt->bindParam(':item_rate_ph', $item_rate_ph);
        $stmt->bindParam(':item_duration', $item_duration);
        $stmt->bindParam(':quantity', $quantity);

        // Execute the statement
        $stmt->execute();

        // Destroy object
        $db = null;

        // Return Message in JSON format
        return '{"notice":{"text":"'.$item_name.' added to qoute '.$qoute_no.'"}}';

    }catch(PDOException $e){
        return '{"error": {"text": '.$e->getMessage().'}}';
    }

});

// UPDATE Qoutation item
$app->post('/api/qoutations/updateitem/{item_id}', function(Request $request, Response $response)
{
        // Get id from url
        $item_id = $request->getAttribute('item_id');

        $qoute_no = $request->getParam('qoute_no');
        $item_name = $request->getParam('item_name');
        $item_desc = $request->getParam('item_desc');
        $item_price = $request->getParam('item_price');
        $item_rate_ph = $request->getParam('item_rate_ph');
        $item_duration = $request->getParam('item_duration');
        $quantity = $request->getParam('quantity');

        // The query
        $qry = "
            UPDATE qoute_items SET
                qoute_no = :qoute_no,
                item_name = :item_name,
                item_desc = :item_desc,
                item_price = :item_price,
                item_rate_ph = :item_rate_ph,
                item_duration = :item_duration,
                quantity = :quantity
            WHERE item_id = $item_id";

        try{
            // Create db connect object
            $db = new db_con();

            //Call the connect method
            $db = $db->connect();

            // Prepare the statement
            $stmt = $db->prepare($qry);

            // Bind values to parameters
            $stmt->bindParam(':qoute_no', $qoute_no);
            $stmt->bindParam(':item_name', $item_name);
            $stmt->bindParam(':item_desc', $item_desc);
            $stmt->bindParam(':item_price', $item_price);
            $stmt->bindParam(':item_rate_ph', $item_rate_ph);
            $stmt->bindParam(':item_duration', $item_duration);
            $stmt->bindParam(':quantity', $quantity);

            // Execute the statement
            $stmt->execute();

            // Destroy object
            $db = null;

            // Return Message in JSON format

            $message = [
                "notice" => array("text" => "$item_name updated")
            ];

            return json_encode($message);

        }catch(PDOException $e){
            return '{"error": {"text": '.$e->getMessage().'}}';
        }


});

// DELETE qoutation item
$app->delete('/api/qoutations/deleteitem/{item_id}', function(Request $request, Response $response){

    $item_id = $request->getAttribute('item_id');

    $qry = "DELETE FROM qoute_items WHERE item_id = $item_id";

    try{
        // Get DB OBJECT
        $db = new db_con();
        $db = $db->connect();

        $stmt = $db->prepare($qry);

        $stmt->execute();

        $db = null;

        return '{"notice":{"text":"Item '.$item_id.' deleted."}}';

    }catch(PDOException $e){
        return '{"error":{"text":'.$e->getMessage().'}}';
    }
});





// SELECT by ID qoutation
$app->get('/api/qoutations/{qoute_no}', function(Request $request, Response $response){

    $qoute_no = $request->getAttribute('qoute_no');

    $qry = "SELECT * FROM qoute_details WHERE qoute_no = $qoute_no";

    $qry2 = "SELECT * FROM qoute_items WHERE qoute_no = $qoute_no";

    try{
        // Get DB OBJECT
        $db = new db_con();
        $db = $db->connect();

        $stmt = $db->query($qry);
        $stmt2 = $db->query($qry2);

        $qoutation = $stmt->fetchAll(PDO::FETCH_OBJ);
        $qoutation_items = $stmt2->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        $qoute = [
            "qoute_details" => $qoutation,
            "qoute_items" => $qoutation_items
        ];

        return json_encode($qoute);

    }catch(PDOException $e){
        return '{"error":{"text":'.$e->getMessage().'}}';
    }

});

// INSERT a qoutation Details
$app->post('/api/qoutations/add', function(Request $request, Response $response){

    $reg_no = $request->getParam('reg_no');
    $client_address = $request->getParam('client_address');
    $client_no = $request->getParam('client_no');
    $client_name = $request->getParam('client_name');
    $client_website = $request->getParam('client_website');
    $client_email = $request->getParam('client_email');
    $qoute_notes = $request->getParam('qoute_notes');
    $qoute_tnc = $request->getParam('qoute_tnc');
    $project_desc = $request->getParam('project_desc');
    $qoute_status = $request->getParam('qoute_status');
    $qoute_date = $request->getParam('qoute_date');
    $veh_reg = $request->getParam('veh_reg');
    $veh_desc = $request->getParam('veh_desc');
    $veh_kilos = $request->getParam('veh_kilos');
    $qoute_ref = $request->getParam('qoute_ref');

    $qry = "INSERT INTO qoute_details
    (
        reg_no,
        client_address,
        client_no,
        client_name,
        client_website,
        client_email,
        qoute_notes,
        qoute_tnc,
        project_desc,
        qoute_status,
        qoute_date,
        veh_reg,
        veh_desc,
        veh_kilos,
        qoute_ref
    ) VALUES(
        :reg_no,
        :client_address,
        :client_no,
        :client_name,
        :client_website,
        :client_email,
        :qoute_notes,
        :qoute_tnc,
        :project_desc,
        :qoute_status,
        :qoute_date,
        :veh_reg,
        :veh_desc,
        :veh_kilos,
        :qoute_ref
    )";

    try{
        // Get DB OBJECT
        $db = new db_con();
        $db = $db->connect();

        $stmt = $db->prepare($qry);

        $stmt->bindParam(':reg_no', $reg_no);
        $stmt->bindParam(':client_address', $client_address);
        $stmt->bindParam(':client_no', $client_no);
        $stmt->bindParam(':client_name', $client_name);
        $stmt->bindParam(':client_website', $client_website);
        $stmt->bindParam(':client_email', $client_email);
        $stmt->bindParam(':qoute_notes', $qoute_notes);
        $stmt->bindParam(':qoute_tnc', $qoute_tnc);
        $stmt->bindParam(':project_desc', $project_desc);
        $stmt->bindParam(':qoute_status', $qoute_status);
        $stmt->bindParam(':qoute_date', $qoute_date);
        $stmt->bindParam(':veh_reg', $veh_reg);
        $stmt->bindParam(':veh_desc', $veh_desc);
        $stmt->bindParam(':veh_kilos', $veh_kilos);
        $stmt->bindParam(':qoute_ref', $qoute_ref);

        $stmt->execute();

        return '{"notice":{"text":"New qoutation added"}}';

    }catch(PDOException $e){
        return '{"error":{"text":'.$e->getMessage().'}}';
    }
});

// UPDATE a qoutation
$app->post('/api/qoutations/update/{qoute_no}', function(Request $request, Response $response)
{

    $qoute_no = $request->getAttribute('qoute_no');

    $reg_no = $request->getParam('reg_no');
    $client_address = $request->getParam('client_address');
    $client_no = $request->getParam('client_no');
    $client_name = $request->getParam('client_name');
    $client_website = $request->getParam('client_website');
    $client_email = $request->getParam('client_email');
    $qoute_notes = $request->getParam('qoute_notes');
    $qoute_tnc = $request->getParam('qoute_tnc');
    $project_desc = $request->getParam('project_desc');
    $qoute_status = $request->getParam('qoute_status');
    $qoute_date = $request->getParam('qoute_date');
    $veh_reg = $request->getParam('veh_reg');
    $veh_desc = $request->getParam('veh_desc');
    $veh_kilos = $request->getParam('veh_kilos');
    $qoute_ref = $request->getParam('qoute_ref');

    $qry = "UPDATE qoute_details SET
                reg_no = :reg_no,
                client_address = :client_address,
                client_no = :client_no,
                client_name = :client_name,
                client_website = :client_website,
                client_email = :client_email,
                qoute_notes = :qoute_notes,
                qoute_tnc = :qoute_tnc,
                project_desc = :project_desc,
                qoute_status = :qoute_status,
                qoute_date = :qoute_date,
                veh_reg = :veh_reg,
                veh_desc = :veh_desc,
                veh_kilos = :veh_kilos,
                qoute_ref = :qoute_ref
            WHERE qoute_no = $qoute_no";

    try{
        // Get DB OBJECT
        $db = new db_con();
        $db = $db->connect();

        $stmt = $db->prepare($qry);

        $stmt->bindParam(':reg_no', $reg_no);
        $stmt->bindParam(':client_address', $client_address);
        $stmt->bindParam(':client_no', $client_no);
        $stmt->bindParam(':client_name', $client_name);
        $stmt->bindParam(':client_website', $client_website);
        $stmt->bindParam(':client_email', $client_email);
        $stmt->bindParam(':qoute_notes', $qoute_notes);
        $stmt->bindParam(':qoute_tnc', $qoute_tnc);
        $stmt->bindParam(':project_desc', $project_desc);
        $stmt->bindParam(':qoute_status', $qoute_status);
        $stmt->bindParam(':qoute_date', $qoute_date);
        $stmt->bindParam(':veh_reg', $veh_reg);
        $stmt->bindParam(':veh_desc', $veh_desc);
        $stmt->bindParam(':veh_kilos', $veh_kilos);
        $stmt->bindParam(':qoute_ref', $qoute_ref);

        $stmt->execute();

        return '{"notice":{"text":"Qoutation '.$qoute_no.' succesfully updated."}';

    }catch(PDOException $e){
        return '{"error":{"text":'.$e->getMessage().'}}';
    }
});

// DELETE qoutation
$app->delete('/api/qoutations/delete/{qoute_no}', function(Request $request, Response $response){

    $qoute_no = $request->getAttribute('qoute_no');

    $qry = "DELETE FROM qoute_details WHERE qoute_no = $qoute_no";

    try{
        // Get DB OBJECT
        $db = new db_con();
        $db = $db->connect();

        $stmt = $db->prepare($qry);

        $stmt->execute();

        $db = null;

        return '{"notice":{"text":"Qoutation '.$qoute_no.' deleted."}}';

    }catch(PDOException $e){
        return '{"error":{"text":'.$e->getMessage().'}}';
    }
});
