function deleteQuestion(qid) {
    var ajax = new XMLHttpRequest();
    var data = [qid];
    ajax.open("POST", "./delete-question.php");
    ajax.setRequestHeader("Content-type", "application/json");
    ajax.send(JSON.stringify(data));
}