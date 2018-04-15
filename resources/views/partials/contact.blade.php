<!DOCTYPE html>
<html lang="en">
<body>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="contact.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/"> I am In! </a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="../events">EVENTS </a></li>
            <li><a href="../create_event">CREATE EVENT</a></li>
            <li><a href="../faq">FAQ</a></li>
            <li><a href="../contact">CONTACT US</a></li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> AUTH <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="../sign_up">Sign Up</a></li>
                    <li><a href="../sign_in">Sign In</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <h2>Contact us</h2>

    <div class="form-group">
        <label class="form" for="name">Name:</label>
        <input type="name" class="form-control" id="name" placeholder="Name" name="name">
    </div>
    <div class="form-group">
        <label class="form" for="email">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="Email" name="email">
    </div>
    <div class="form-group">
        <label class="form" for="phone">Phone number</label>
        <input type="phoneNumber" class="form-control" id="phone" placeholder="Phone number" name="phone">
    </div>
    <div class="form-group">
        <label class="form" for="comment">Comment:</label>
        <textarea class="form-control" placeholder="You can leave us a comment" rows="5" id="comment"></textarea>
    </div>
    <button type="submit" class="btn btn-default">Send</button>
    </form>
</div>
</body>
<footer class="copyright">
    <div class="footer-copyright py-3 text-center">
        <div class="container">
            <hr>
            © 2018 I am In!
        </div>
    </div>
</footer>

</html>