<!DOCTYPE html>
<html>
<head>
<title>Micro Internship Marketplace
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}
body{
    background:#f8fbff;
    color:#0f172a;
}

/* NAVBAR */
.navbar{
    height:85px;
    background:rgba(255,255,255,0.95);
    backdrop-filter:blur(12px);
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 70px;
    box-shadow:0 4px 22px rgba(15,23,42,0.08);
    position:sticky;
    top:0;
    z-index:100;
}

.logo{
    font-size:28px;
    font-weight:900;
    letter-spacing:1px;
    text-transform:uppercase;
    background:linear-gradient(135deg,#0284c7,#38bdf8,#2563eb,#9333ea);
    -webkit-background-clip:text;
    color:transparent;
    text-shadow:2px 3px 8px rgba(14,165,233,0.18);
}

.nav-links a{
    text-decoration:none;
    margin-left:30px;
    color:#1e293b;
    font-size:18px;
    font-weight:700;
}

.nav-links a:hover{
    color:#2563eb;
}

.nav-links .login{
    color:#2563eb;
    border:2px solid #2563eb;
    padding:10px 20px;
    border-radius:12px;
}

.nav-links .register{
    color:white;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    border:2px solid transparent;
    padding:10px 20px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(37,99,235,0.28);
}

/* HERO */
.hero{
    min-height:calc(100vh - 85px);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:45px;
    padding:70px 70px 65px;
    background:
        radial-gradient(circle at top left, rgba(56,189,248,0.35), transparent 35%),
        radial-gradient(circle at bottom right, rgba(147,51,234,0.18), transparent 35%),
        linear-gradient(135deg,#eff6ff,#e0f2fe);
    overflow:hidden;
}

.hero-text{
    width:52%;
    z-index:3;
}


.hero-text h1{
    font-size:62px;
    line-height:1.15;
    margin-bottom:24px;
    letter-spacing:-1px;
}

.hero-text h1{
    font-size:48px;
    line-height:1.12;
    margin-bottom:24px;
    letter-spacing:-2px;
    font-weight:900;
}

.hero-text h1 span{
    background:linear-gradient(135deg,#0f766e,#14b8a6,#0891b2);
    -webkit-background-clip:text;
    color:transparent;
}

.hero-text p{
    font-size:21px;
    line-height:1.8;
    color:#475569;
    margin-bottom:35px;
    max-width:720px;
    font-weight:400;
}

.hero-buttons{
    display:flex;
    gap:16px;
    align-items:center;
    margin-bottom:35px;
}

.primary{
    text-decoration:none;
    padding:16px 32px;
    border-radius:14px;
    font-weight:bold;
    font-size:18px;
    display:inline-block;
    background:linear-gradient(135deg,#2563eb,#0284c7);
    color:white;
    box-shadow:0 14px 28px rgba(37,99,235,0.35);
}

.secondary{
    text-decoration:none;
    padding:16px 32px;
    border-radius:14px;
    font-weight:bold;
    font-size:18px;
    display:inline-block;
    background:white;
    color:#2563eb;
    border:2px solid #bfdbfe;
    box-shadow:0 10px 22px rgba(15,23,42,0.08);
}

.primary:hover,
.secondary:hover{
    transform:translateY(-3px);
    transition:0.3s;
}

.stats{
    display:flex;
    gap:20px;
    margin-top:20px;
}

.stat-box{
    background:rgba(255,255,255,0.92);
    padding:20px 24px;
    border-radius:18px;
    box-shadow:0 12px 28px rgba(15,23,42,0.10);
    border:1px solid rgba(186,230,253,0.9);
    min-width:145px;
}

.stat-box h3{
    background:linear-gradient(135deg,#0284c7,#2563eb);
    -webkit-background-clip:text;
    color:transparent;
    font-size:30px;
    margin-bottom:5px;
}

.stat-box p{
    font-size:15px;
    margin:0;
    color:#334155;
}

/* HERO IMAGE */
.hero-image{
    width:43%;
    position:relative;
}

.image-card{
    position:relative;
    border-radius:32px;
    overflow:hidden;
    box-shadow:0 28px 70px rgba(15,23,42,0.28);
    z-index:2;
    background:white;
}

.image-card img{
    width:100%;
    height:500px;
    object-fit:cover;
    display:block;
}

/* FEATURES */
.features{
    padding:70px;
    background:white;
}

.section-title{
    text-align:center;
    margin-bottom:45px;
}

.section-title h2{
    font-size:42px;
    color:#0f172a;
    margin-bottom:12px;
}

.section-title p{
    color:#64748b;
    font-size:18px;
}

.feature-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:25px;
}

.feature-card{
    background:linear-gradient(135deg,#f8fbff,#eff6ff);
    border:1px solid #bae6fd;
    padding:30px;
    border-radius:24px;
    box-shadow:0 12px 30px rgba(2,132,199,0.10);
}

.feature-card h3{
    color:#075985;
    margin-bottom:12px;
    font-size:22px;
}

.feature-card p{
    color:#475569;
    line-height:1.6;
    font-size:16px;
}

/* RESPONSIVE */
@media(max-width:1000px){
    .navbar{
        padding:0 25px;
    }

    .logo{
        font-size:26px;
    }

    .nav-links a{
        margin-left:12px;
        font-size:15px;
    }

    .hero{
        flex-direction:column;
        padding:45px 25px;
        gap:30px;
    }

    .hero-text,
    .hero-image{
        width:100%;
    }

    .hero-text h1{
        font-size:42px;
    }

    .hero-text p{
        font-size:18px;
    }

    .hero-image{
        margin-top:20px;
    }

    .image-card img{
        height:380px;
    }

    .feature-grid{
        grid-template-columns:1fr;
    }

    .features{
        padding:45px 25px;
    }

    .stats{
        flex-wrap:wrap;
    }
}

@media(max-width:600px){
    .navbar{
        height:auto;
        padding:20px;
        flex-direction:column;
        gap:15px;
    }

    .nav-links{
        display:flex;
        flex-wrap:wrap;
        justify-content:center;
        gap:10px;
    }

    .nav-links a{
        margin-left:0;
    }

    .hero-text h1{
        font-size:36px;
    }

    .hero-buttons{
        flex-direction:column;
        align-items:flex-start;
    }

    .primary,
    .secondary{
        width:100%;
        text-align:center;
    }
}
</style>

</head>

<body>

<div class="navbar">
   <div class="logo">Micro-Internship</div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a class="login" href="auth/login.php">Login</a>
        <a class="register" href="auth/register.php">Register</a>
    </div>
</div>

<section class="hero">
    <div class="hero-text">
        

        <h1>
            Build real skills with 
            <span>micro-internship</span>
            tasks
        </h1>

        <p>
            A database-driven platform where students discover short-term tasks,
            apply for opportunities, submit work, and earn ratings from companies.
        </p>

        <div class="hero-buttons">
            <a class="primary" href="auth/register.php">Get Started</a>
            <a class="secondary" href="about.php">Explore More</a>
        </div>

        <div class="stats">
            <div class="stat-box">
                <h3>100+</h3>
                <p>Students</p>
            </div>

            <div class="stat-box">
                <h3>50+</h3>
                <p>Tasks Posted</p>
            </div>

            <div class="stat-box">
                <h3>4.9/5</h3>
                <p>Rating System</p>
            </div>
        </div>
    </div>

    <div class="hero-image">
        <div class="image-card">
            <img src="https://devwebtechnologys-website.yolasite.com/ws/media-library/7f200f97fa32484da60d83028836b4da/giphy5.gif" alt="Study Animation">
        </div>
    </div>
</section>

<section class="features">
    <div class="section-title">
        <h2>How It Works</h2>
        <p>Simple workflow for students and companies</p>
    </div>

    <div class="feature-grid">
        <div class="feature-card">
            <h3>Students Apply</h3>
            <p>
                Students browse open micro-internship tasks and apply based on
                their skills, interest, and available time.
            </p>
        </div>

        <div class="feature-card">
            <h3>Companies Select</h3>
            <p>
                Companies review applications, accept suitable students, and
                assign deadlines automatically based on task duration.
            </p>
        </div>

        <div class="feature-card">
            <h3>Submit & Review</h3>
            <p>
                Students submit completed work. Companies approve, request
                revision, or provide ratings and feedback after completion.
            </p>
        </div>
    </div>
</section>

</body>
</html>