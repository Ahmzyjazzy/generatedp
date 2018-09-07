<!DOCTYPE html>
<html>
<head>
	<title>DP</title>
	<link rel="stylesheet" type="text/css" href="src/css/style.css">
	<link rel="stylesheet" type="text/css" href="src/fonts/themify-icons.css">
</head>
<body>

	<header>
		<h1>KwaraBuild Conference "18</h1>
	</header>

	<main>

		<section class="under">			
			<div>
				<h2>Display Picture (DP) Generator</h2>
				<p class="">Upload photo to create your Kwarabuild Conference 2018 DP</p>
				<p class="step">To generate your personalized DP</p>
			</div>	
			<ul>
				<li class="ti">Enter your name in the name field below</li>
				<li class="ti">Upload your picture (for best experience, crop the picture to square)</li>
				<li class="ti">Click on Create your own DP</li>
				<li class="ti">Dont forget to share on 
					<span class="ti-facebook" style="color: rgb(29, 45, 130);">facebook</span>, 
					<span class="ti-twitter" style="color: #03A9F4;">twitter</span>, 
					<span class="ti-instagram" style="color: #00BCD4;">instagram</span>, and make sure you hashtag (#kwarabuildconf, #kwarabuild)</li>
			</ul>
		</section>

		<section class="top">

			<form enctype="multipart/form-data" action="upload.php" method="POST">
                <h1>Details</h1>
                <div class="form-control">
                    <input placeholder="Name" required="" id="fullname" name="fullname" type="text">
                </div>
                <div class="form-control">
                	<input align="center" name="file" type="file" required="">
                </div>                
                <div class="button">                
                	<button value="submit" class="kb-button">Create your own DP</button>        
            	</div><!-- button -->

            </form>
			
		</section>
		
	</main>

	<footer>
		<p> &copy; Kwarabuild 2018. All Rights Reserved.</p>
	</footer>

</body>
</html>