 <?php include '../srv_utils/dbconfig.php';
    /** Taken from Kayli's HTML code on github, may or may not work who knows */

    $con = mysqli_connect($host, $username, $password, $dbname);
    
    $input_question = $_POST['question-text'];
    $input_id = $_POST['instructor_guid']; //requires linking in HTML file


    /** if statement takes a submit button within */
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['submit'])) {
            $insert = "INSERT INTO bitlab.question-bank (`Instructor GUID`,`Saved Questions`) VALUES 
            ($input_id, $input_question)";
            if ($con->query($insert) == TRUE) {
                //echo success
            }else {
                //echo failed
            }
        } else { 
              
        }
    }

?>