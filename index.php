<?php 
    $indexArray;
    initPage();

    function initPage(){
        if(isContactSaveButtonClicked() && !isSearchContactTriggered()){
            $contact_data = $_POST["name"] . "," . $_POST["work"] . "," . $_POST["mobile"] . "," . $_POST["email"] . "," . $_POST["address"];
            $contact_name = $_POST["name"];
            $contact_size_position = insertContactDataIntoFile($contact_data);
            $contact_index_data = $contact_name . "," . $contact_size_position;
            insertIndexintoFile($contact_index_data);
        }
        else if(isContactRemoveButtonClicked()){
            $contact_name = $_POST["remove-name"];
        }
    }

    function isContactRemoveButtonClicked(){
        return isset($_POST["remove-name"]);
    }

    

    function showForm(){

        if(isSearchContactTriggered()){
            $name_searched = $_POST["name"];
            $contact_data_bundle = getContactInformationByLimits($name_searched);
            $contact_data_array = explode(",",$contact_data_bundle);

            echo "<form id='save-contact' method='POST'>";
            echo "<label for='name'>Name:</label>";
            echo "<input type='text' id='name' name='name' value='". $contact_data_array[0] . "'>";
            echo "<label for='work'>Work:</label>";
            echo "<input type='text id='work' name='work' value='". $contact_data_array[1] ."'>";
            echo "<label for='mobile'>Mobile:</label>";
            echo "<input type='text' id='mobile' name='mobile' value='". $contact_data_array[2] ."'>";
            echo "<label for='email'>E-mail:</label>";
            echo "<input type='text' id='email' name='email' value='". $contact_data_array[3] ."'>";
            echo "<label for='address'>Address:</label>";
            echo "<textarea form='save-contact' id='address' name='address'>". $contact_data_array[4] ."</textarea>";
            echo "<button type='submit'>Save</button>";
            echo "</form>";
        }
        else{
            echo "guardo algo";
            echo "<form id='save-contact' method='POST'>";
            echo "<label for='name'>Name:</label>";
            echo "<input type='text' id='name' name='name'>";
            echo "<label for='work'>Work:</label>";
            echo "<input type='text id='work' name='work'>";
            echo "<label for='mobile'>Mobile:</label>";
            echo "<input type='text' id='mobile' name='mobile'>";
            echo "<label for='email'>E-mail:</label>";
            echo "<input type='text' id='email' name='email'>";
            echo "<label for='address'>Address:</label>";
            echo "<textarea form='save-contact' id='address' name='address'></textarea>";
            echo "<button type='submit'>Save</button>";
            echo "</form>";
        }
        
    }

    function isSearchContactTriggered(){
        return !empty($_POST["name"]) && empty($_POST["work"]) && empty($_POST["mobile"]) && empty($_POST["email"]) && empty($_POST["address"]); 
    }

    function getContactInformationByLimits($name){
        $limitsArray = getLimitsArray($name);
        if(file_exists("contacts.txt")){
            $contactsFile = fopen("contacts.txt","r");
            $isSuccess = fseek($contactsFile, $limitsArray[0]);
            if($isSuccess == 0){
                $lenght = $limitsArray[1] - $limitsArray[0];
                $contact_data = fread($contactsFile,$lenght);
                return $contact_data;
            }
            else{
                return false;
            }

        }
        else{
            return false;
        }
    }

    function getLimitsArray($name){
        $IndexArray = getIndexArrayFromFile();
        $start = -1;
        $finish = 0;

        foreach($IndexArray as $item){
            $dataArray = explode(",",$item);
            $start = $finish;
            $finish = $dataArray[1];
            if($dataArray[0] == $name){
                break;
            }
        }
        $limits = array((int)$start,(int)$finish);
        return $limits;
    }

    function fillContactsTable(){
        $dataIndexArray = getIndexArrayFromFile();
        if($dataIndexArray != false){
            foreach($dataIndexArray as $item){
                $dataArray = explode(",",$item);
                echo "<tr><td>" . $dataArray[0] . "</td></tr>";
            }
        }
    }

    function getIndexArrayFromFile(){
        if(!file_exists("index.txt")){
            return false;
        }
        else{
            $indexFile = fopen("index.txt","r");
            if(!$indexFile){
                return false;
            }
            else{
                global $indexArray;
                $indice = 0;
                while(!feof($indexFile)){
                    fseek($indexFile,$indice*40);
                    $data = fread($indexFile,40);
                    $indexArray[$indice] = $data;
                    $indice++; 
                }
                return $indexArray;
            }
        }
    }

    function isContactSaveButtonClicked(){
        return isset($_POST["name"]) && isset($_POST["work"]) && isset($_POST["mobile"]) && isset($_POST["email"]) && isset($_POST["address"]);
    }

    function insertContactDataIntoFile($data){
        $position;
        $wasUploadedSuccessfully = file_put_contents("contacts.txt",$data,FILE_APPEND | LOCK_EX);
        if ($wasUploadedSuccessfully === false){
            return false;
        }
        else{
            $position = filesize("contacts.txt");
            return $position;
        }
    }

    function insertIndexintoFile($data){
        $data = str_pad($data,40," ");
        $wasUploadedSuccessfully = file_put_contents("index.txt",$data,FILE_APPEND | LOCK_EX);
        if ($wasUploadedSuccessfully === false){
            echo "There was an error writing in index.txt file";
        }
        else{
            //echo $wasUploadedSuccessfully;
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Tarea 3 - Manejo de Archivos</title>
    </head>
    <body>
        <header></header>
        <main id="container">
        <section id="all-contacts">
            <h3>All Contacts</h3>
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        fillContactsTable();
                    ?>
                </tbody>
            </table>
        </section>
        <section id="add-contact">
            <?php
            showForm(); 
            ?>
        </section>
        <section id="remove-contact">
            <form id='remove-contact' method='POST'>
                <input type="text" id="remove-name" name="remove-name">
                <button type='submit'>Eliminar</button>
            </form>
        </section>
        </main>
        <footer></footer>
    </body>
</html>