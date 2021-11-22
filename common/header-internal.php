<div class="page-wrapper"> <!-- closed in footer -->
<header>
    <div><h1><a href="/">&lt;bitlab/&gt;</a></h1></div>
    <div id="login-toolbar">
        <form action="/profile/logout.php">
            <button type="submit"><span style="padding-right: 0.5em; padding-top: 0.15em;"><?php echo($_SESSION['first_name'] . " " . $_SESSION['last_name']);?></span><span class="material-icons-sharp">logout</span></button>
        </form>
    </div>
</header>