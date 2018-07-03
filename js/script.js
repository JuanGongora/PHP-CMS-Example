/**
 * https://stackoverflow.com/questions/3535996/jquery-javascript-functione-what-is-e-why-is-it-needed-what-does-it-ac
 *
 * Send links of class "delete" via post after a confirmation dialog
 *
 * If user has Javascript turned off in their browser, then the PHP version that was
 * already built (i.e. delete-article.php, delete-article-image.php) will be run instead
 */
$("a.delete").on("click", function(e) {

    e.preventDefault()

    if (confirm("Are you sure?")) {

        //creates an html form element on the fly in order to reference a post method
        var frm = $("<form>");
        frm.attr('method', 'post');
        //this is creating an action that links to a delete url that is described in the id tag that #delete-article comes from (delete-article.php)
        frm.attr('action', $(this).attr('href'));
        //adds this dynamic form into the body of the html page as it's submitted through the delete action
        frm.appendTo("body");
        frm.submit();
    }
});



