<!DOCTYPE html>
<html>
<head>
<title>About - Micro Internship</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f8fbff;
    color:#0f172a;
}

.navbar{
    height:85px;
    background:white;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 70px;
    box-shadow:0 4px 18px rgba(0,0,0,0.08);
}

.logo{
    font-size:34px;
    font-weight:900;
    letter-spacing:1px;
    text-transform:uppercase;
    background:linear-gradient(135deg,#0284c7,#38bdf8,#2563eb);
    -webkit-background-clip:text;
    color:transparent;
    text-shadow:2px 3px 8px rgba(14,165,233,0.20);
}

.nav-links a{
    text-decoration:none;
    margin-left:30px;
    color:#1e293b;
    font-size:18px;
    font-weight:600;
}

.nav-links a:hover,
.nav-links .active{
    color:#2563eb;
}

.login{
    color:#2563eb !important;
    border:2px solid #2563eb;
    padding:9px 17px;
    border-radius:8px;
}

.register{
    color:white !important;
    background:#2563eb;
    border:2px solid #2563eb;
    padding:9px 17px;
    border-radius:8px;
}

.about{
    min-height:calc(100vh - 85px);
    padding:70px;
    background:linear-gradient(135deg,#f8fbff,#e0f2fe);
}

.title{
    text-align:center;
    margin-bottom:60px;
}

.title h1{
    font-size:56px;
    color:#0f172a;
}

.title h1 span{
    color:#2563eb;
}

.title p{
    font-size:24px;
    color:#475569;
    margin-top:20px;
}

.intro{
    max-width:1000px;
    margin:0 auto 55px;
    text-align:center;
    font-size:21px;
    line-height:1.7;
    color:#334155;
}

.highlight{
    text-align:center;
    font-size:30px;
    color:#2563eb;
    font-weight:bold;
    margin-bottom:55px;
}

.mission-box{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:45px;
}

.mission-text{
    width:50%;
    background:#eef6ff;
    padding:40px;
    border-radius:22px;
    box-shadow:0 15px 35px rgba(2,132,199,0.15);
    border:1px solid #bae6fd;
}

.mission-text h2{
    color:#2563eb;
    font-size:34px;
    margin-bottom:20px;
}

.mission-text p{
    font-size:20px;
    color:#334155;
    line-height:1.7;
}

.mission-img{
    width:48%;
}

.mission-img img{
    width:100%;
    height:360px;
    object-fit:cover;
    border-radius:22px;
    box-shadow:0 18px 40px rgba(15,23,42,0.22);
}

@media(max-width:900px){
    .navbar{
        padding:0 25px;
    }

    .nav-links a{
        margin-left:12px;
        font-size:15px;
    }

    .about{
        padding:40px 25px;
    }

    .title h1{
        font-size:38px;
    }

    .mission-box{
        flex-direction:column;
    }

    .mission-text,
    .mission-img{
        width:100%;
    }
}
</style>
</head>

<body>

<div class="navbar">
    <div class="logo">Micro-Internship</div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a class="active" href="about.php">About</a>
        <a class="login" href="auth/login.php">Login</a>
        <a class="register" href="auth/register.php">Register</a>
    </div>
</div>

<section class="about">

    <div class="title">
        <h1>Welcome to <span>Micro-Intern</span></h1>
        <p>Your gateway to short-term internship tasks and career growth</p>
    </div>

    <div class="intro">
        Micro-Intern is a database-driven marketplace system that connects students
        with companies offering short-term task-based internship opportunities.
        It helps students gain real project experience while allowing companies to
        find skilled and motivated learners for small professional tasks.
    </div>

    <div class="highlight">
        We simplify the micro-internship journey for everyone.
    </div>

    <div class="mission-box">
        <div class="mission-text">
            <h2>🎯 Our Mission</h2>
            <p>
                Our mission is to create a structured and transparent platform where
                students can apply for tasks, submit completed work, receive feedback,
                and build their profile through ratings and reviews.
                At the same time, companies can post tasks, select students,
                evaluate submissions, and manage the complete internship workflow easily.
            </p>
        </div>

        <div class="mission-img">
           <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=900&q=80">
        </div>
    </div>

</section>

</body>
</html>