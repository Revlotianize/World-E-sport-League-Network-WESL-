<?php

	$con = mysqli_connect("localhost", "root", "", "wesl_one") or die ("Connection was not established");

			if(isset($_GET['lang'])){
				$lang = $_GET['lang'];

				$_SESSION['lang'] = $lang;
				setcookie('lang', $lang, time() + (3600 * 24 * 30));
			}
			else if(isset($_SESSION['lang'])){
				$lang = $_SESSION['lang'];
			}
			else if(isset($_COOKIE['lang'])){
				$lang = $_COOKIE['lang'];
			}
			else {
				$lang = 'en';
			}
			switch ($lang) {
			case 'en':
			$lang_file = 'lang.en.php';
			break;
			case 'de':
			$lang_file = 'lang.de.php';
			break;
			default:
			$lang_file = 'lang.en.php';
			}
			include_once 'locale/'.$lang_file;

		function login(){

		global $con;
		global $lang;

			if(isset($_POST['login'])){

				$email		= mysqli_real_escape_string($con, $_POST['email']);
				$pass		= mysqli_real_escape_string($con, $_POST['pass']);

				$get_user	= "select * from users where user_email='$email' AND user_pass='$pass'";
				$run_user	= mysqli_query($con, $get_user);
				$check 		= mysqli_num_rows($run_user);

				if($check==1){
					$users = mysqli_fetch_array($run_user);
					$_SESSION['user_email']=$email;
					$_SESSION['user_id']=$users['user_id'];
					echo "<script>window.open('index.php','_self')</script>";
					#echo "<meta http-equiv='refresh' content='0'>";
				}
				else {
				echo "<font color='darkorange'>Email/Password is not correct!</font>";
				}
			}
		}

		function newUser(){

		global $con;
		global $lang;

			if(isset($_POST['sign_up'])){

				$name		= mysqli_real_escape_string($con, $_POST['u_name']);
				$pass		= mysqli_real_escape_string($con, $_POST['u_pass']);
				$pass2		= mysqli_real_escape_string($con, $_POST['u_pass2']);
				$email		= mysqli_real_escape_string($con, $_POST['u_email']);
				$country	= mysqli_real_escape_string($con, $_POST['u_country']);
				$gender		= mysqli_real_escape_string($con, $_POST['u_gender']);
				$bday		= mysqli_real_escape_string($con, $_POST['u_bday']);

				$get_user		= "select * from users where user_name='$name'";
				$run_user		= mysqli_query($con, $get_user);
				$check_user 	= mysqli_num_rows($run_user);

				if($check_user==1){
				echo "<script>alert('Username already exists!')</script>";
				exit();
				}

				$get_email		= "select * from users where user_email='$email'";
				$run_email		= mysqli_query($con, $get_email);
				$check_email 	= mysqli_num_rows($run_email);

				if($check_email==1){
				echo "<script>alert('Email is already registerd!')</script>";
				exit();
				}

				if($pass != $pass2){
						echo "<script>alert('Passwords do not match!')</script>";
						exit;
				}

				if(strlen($pass)<6){
				echo "<script>alert('Password should be minimum 6 characters!')</script>";
				exit();
				}
				else {

					$insert = "insert into users (user_name,user_pass,user_email,user_country,user_gender,user_bday,user_image,register_date,last_login,status) values ('$name','$pass','$email','$country','$gender','$bday','default.jpg',NOW(),NOW(),'unverified')";
					$run_insert = mysqli_query($con, $insert); {

						if($run_insert){
						$_SESSION['user_email']=$email;
						echo "<script>alert('Registration successful!')</script>";
						echo "<script>window.open('index.php','_self')</script>";
						#echo "<meta http-equiv='refresh' content='0'>";
						}
					}
				}
			}
		}

		# count total hits
		function countHits(){

			$count_my_page = ("hits.txt");
			$hits = file($count_my_page);
			$hits[0] ++;
			$fp = fopen($count_my_page , "w");
				fputs($fp , "$hits[0]");
				fclose($fp);
				echo $hits[0];
		}

		# BBcodes function
		function BBcodesHTML($text) {

			$find = array(
				'~\[br\](.*?)\[/br\]~s',
				'~\[b\](.*?)\[/b\]~s',
				'~\[i\](.*?)\[/i\]~s',
				'~\[u\](.*?)\[/u\]~s',
				'~\[quote\](.*?)\[/quote\]~s',
				'~\[size=(.*?)\](.*?)\[/size\]~s',
				'~\[color=(.*?)\](.*?)\[/color\]~s',
				'~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
				'~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
			);

			$replace = array(
				'<br>$1</br>',
				'<b>$1</b>',
				'<i>$1</i>',
				'<span style="text-decoration:underline;">$1</span>',
				'<pre>$1</'.'pre>',
				'<span style="font-size:$1px;">$2</span>',
				'<span style="color:$1;">$2</span>',
				'<a href="$1">$1</a>',
				'<img src="$1" alt="" />'
			);

			return preg_replace($find,$replace,$text);
		}

		# html from database to bbcode for user edit
		function HTMLBBcodes($text) {

			$find = array(
				'~\<br\>(.*?)\</br\>~s',
				'~\<b\>(.*?)\</b\>~s',
				'~\<i\>(.*?)\</i\>~s',
				'~\<u\>(.*?)\</u\>~s',
				'~\<quote\>(.*?)\</quote\>~s',
				'~\<size=(.*?)\>(.*?)\</size\>~s',
				'~\<color=(.*?)\>(.*?)\</color\>~s',
				'~\<url\>((?:ftp|https?)://.*?)\</url\>~s',
				'~\<img\>(https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\</img\>~s'
			);

			$replace = array(
				'[br]$1[/br]',
				'[b]$1[/b]',
				'[i]$1[/i]',
				'[span style="text-decoration:underline;"]$1[/span]',
				'[pre]$1[/'.'pre]',
				'[span style="font-size:$1px;"]$2[/span]',
				'[span style="color:$1;"]$2[/span]',
				'[a href="$1"]$1[/a]',
				'[img src="$1" alt="" /]'
			);

			return preg_replace($find,$replace,$text);
		}

		/*
		function getTopics(){

		global $con;

			$get_topics = "select * from topics";
			$run_topics = mysqli_query($con, $get_topics);

			while($row=mysqli_fetch_array($run_topics)){

				$topic_id		= $row['topic_id'];
				$topic_title	= $row['topic_title'];

				echo "<option value='$topic_id'>$topic_title</a></option>";
			}
		}
		*/

		function getTopicName(){

		global $con;

			if(isset($_GET['topic'])){
				$topic_id = $_GET['topic'];
				}

			$get_topics = "select * from topics where topic_id='$topic_id'";
			$run_topics = mysqli_query($con, $get_topics);

			while($row=mysqli_fetch_array($run_topics)){

				$topic_id		= $row['topic_id'];
				$topic_title	= $row['topic_title'];

				echo "$topic_title";
			}
		}


		function showMenu(){

		global $con;
		global $lang;

			if(isset($_GET['topic'])  || strpos($_SERVER['REQUEST_URI'], "index.php") === false){
				echo "<li><a href='index.php'>{$lang['MENU_HOME']}</a></li>";
			}
			else {
				echo "<li><a class='active' href='index.php'>{$lang['MENU_HOME']}</a></li>";
			}

			if(isset($_GET['topic'])  || strpos($_SERVER['REQUEST_URI'], "userlist.php") === false){
				echo "<li><a href='userlist.php'>{$lang['MENU_USERLIST']}</a></li>";
			}
			else {
				echo "<li><a class='active' href='userlist.php'>{$lang['MENU_USERLIST']}</a></li>";
			}

			if(isset($_GET['topic'])  || strpos($_SERVER['REQUEST_URI'], "teams.php") === false){
				echo "<li><a href='teams.php'>{$lang['MENU_TEAMS']}</a></li>";
			}
			else {
				echo "<li><a class='active' href='teams.php'>{$lang['MENU_TEAMS']}</a></li>";
			}

			if(isset($_GET['topic'])  || strpos($_SERVER['REQUEST_URI'], "matches.php") === false){
				echo "<li><a href='matches.php'>{$lang['MENU_MATCHES']}</a></li>";
			}
			else {
				echo "<li><a class='active' href='matches.php'>{$lang['MENU_MATCHES']}</a></li>";
			}

			$get_topics = "select * from topics";
			$run_topics = mysqli_query($con, $get_topics);

			while($row=mysqli_fetch_array($run_topics)){

				$topic_id		= $row['topic_id'];
				$topic_title	= $row['topic_title'];

				if(isset($_GET['topic']) && $row['topic_id'] == $_GET['topic']){

					echo "<li><a class='active' href='topics.php?topic=$topic_id'>$topic_title</a></li>";
				}
				else {

					echo "<li><a href='topics.php?topic=$topic_id'>$topic_title</a></li>";
				}
			}
		}

		function getSearchQuery(){

		global $con;

			if(isset($_GET['user_query'])){
				$search_term = $_GET['user_query'];
				}
			if($search_term==''){
				$search_term = "~nothing";
			}
				echo "<i>$search_term</i>";
		}

		# home.php
		function userDetails(){

		global $con;
		global $lang;

			$user			= $_SESSION['user_email'];
			$get_user 		= "select * from users where user_email='$user'";
			$run_user 		= mysqli_query($con, $get_user);
			$row			= mysqli_fetch_array($run_user);

			$user_id		= $row['user_id'];
			$user_image		= $row['user_image'];

			$user_msgs = "select * from messages where receiver_id='$user_id' AND status='unread'";
			$run_msgs = mysqli_query($con, $user_msgs);
			$count_msgs = mysqli_num_rows($run_msgs);

			if($count_msgs == 0){
				$new_msgs = "";
			}
			else {
				$new_msgs = " (<b>$count_msgs</b>)";
			}

			$user_posts = "select * from posts where user_id='$user_id'";
			$run_posts = mysqli_query($con, $user_posts);
			$count_posts = mysqli_num_rows($run_posts);

			echo "	<center>
						<img src='images/user_images/$user_image' width='200' height='200'>
					</center>
					<br />
					<div id='green'>
						<li><a href='my_messages.php'>{$lang['MENU_MESSAGES']}$new_msgs</a></li>
					</div>
					<li><a href='my_posts.php?u_id=$user_id'>{$lang['MENU_POSTS']} ($count_posts)</a></li>
					<div id='bleen'>
						<li><a href='my_teams.php'>{$lang['MENU_MYTEAMS']}</a></li>
					</div>
					<div id='purple'>
						<li><a href='my_matches.php'>{$lang['MENU_MYMATCHES']}</a></li>
					</div>
					<div id='blue'>
						<li><a href='edit_profile.php'>{$lang['MENU_EDIT_PROFILE']}</a></li>
					</div>
					<div id='orange'>
						<li><a href='edit_account.php'>{$lang['MENU_EDIT_ACCOUNT']}</a></li>
					</div>
					<div id='red'>
						<li><a href='logout.php'>{$lang['MENU_LOGOUT']}</a></li>
					</div>";
		}

		# my_posts.php
		function userPosts(){

		global $con;
		global $lang;

			#$per_page=5;
			#
			#if (isset($_GET['page'])){
			#$page = $_GET['page'];
			#}
			#else {
			#$page=1;
			#}
			#$start_from = ($page-1) * $per_page;

			if(isset($_GET['u_id'])){
				$u_id = $_GET['u_id'];
			}

			$get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC";
			$run_my_posts = mysqli_query($con, $get_posts);

			while($row_posts=mysqli_fetch_array($run_my_posts)){

				$post_id 		= $row_posts['post_id'];
				$topic_id 		= $row_posts['topic_id'];
				$user_id 		= $row_posts['user_id'];
				$post_title 	= $row_posts['post_title'];
				$post_content 	= $row_posts['post_content'];
				$post_date 		= $row_posts['post_date'];

				$user = "select * from users where user_id='$user_id' AND posts='yes'";

				$run_user 		= mysqli_query($con,$user);
				$row_user		= mysqli_fetch_array($run_user);
				$user_name 		= $row_user['user_name'];
				$user_image 	= $row_user['user_image'];

				$get_title = "select topic_title from topics where topic_id='$topic_id'";
				$title = mysqli_query($con, $get_title);

				$get_comments = "select * from comments where post_id='$post_id'";
				$run_comments = mysqli_query($con, $get_comments);
				$count_comments = mysqli_num_rows($run_comments);

				while($row=mysqli_fetch_array($title)){
					$topic_title	= $row['topic_title'];
				}

				echo "	<p><img src='images/user_images/$user_image' width='60' height='60'></p>
						<h2><a href='user_profile.php?u_id=$user_id'>$user_name</a></h2>
						<h3>$post_title <small>($post_date)</small></h3>
						<p><a href='single.php?post_id=$post_id'>$count_comments {$lang['COMMENTS']}</a></p>
						<div id='topics_button'>
							<a href='topics.php?topic=$topic_id'><button>$topic_title</button></a>
						</div>
						<br />
						<p>$post_content</p>
						<br />
						<div id='delete_button'><a href='delete_post.php?post_id=$post_id'><button>{$lang['DELETE_BUTTON']}</button></a></div>
						<div id='edit_button'><a href='edit_post.php?post_id=$post_id'><button>{$lang['EDIT_BUTTON']}</button></a></div>
						<div id='reply_button'><a href='single.php?post_id=$post_id'><button>{$lang['REPLY_BUTTON']}</button></a></div>
						<br />
						<br />
						<hr />";
			}

				#$query = "select * from posts where user_id='$u_id'";
				#$result = mysqli_query($con, $query);
				#$total_posts = mysqli_num_rows($result);
				#$total_pages = ceil($total_posts / $per_page);
				#
				#echo "<br /><center><div id='pagination'><a href='my_posts.php?page=1'>{$lang['FIRST_PAGE_BUTTON']}</a>";
				#for ($i=1; $i<=$total_pages; $i++) {
				#echo "<a href='my_posts.php?page=$i'>$i</a>";
				#}
				#echo "<a href='my_posts.php?page=$total_pages'>{$lang['LAST_PAGE_BUTTON']}</a></div></center>";

		}

		# home.php
		function getPosts(){

		global $con;
		global $lang;

			$per_page=5;

			if (isset($_GET['page'])){
			$page = $_GET['page'];
			}
			else {
			$page=1;
			}
			$start_from = ($page-1) * $per_page;

			$get_posts = "select * from posts ORDER by 1 DESC LIMIT $start_from, $per_page";
			$run_posts = mysqli_query($con,$get_posts);

			while($row_posts=mysqli_fetch_array($run_posts)){

				$post_id 		= $row_posts['post_id'];
				$topic_id 		= $row_posts['topic_id'];
				$user_id 		= $row_posts['user_id'];
				$post_title 	= $row_posts['post_title'];
				$post_content 	= $row_posts['post_content'];
				$post_date 		= $row_posts['post_date'];

				$user = "select * from users where user_id='$user_id' AND posts='yes'";

				$run_user 		= mysqli_query($con,$user);
				$row_user		= mysqli_fetch_array($run_user);
				$user_name 		= $row_user['user_name'];
				$user_image 	= $row_user['user_image'];

				$get_title = "select topic_title from topics where topic_id='$topic_id'";
				$title = mysqli_query($con, $get_title);

				$get_comments = "select * from comments where post_id='$post_id'";
				$run_comments = mysqli_query($con, $get_comments);
				$count_comments = mysqli_num_rows($run_comments);

				while($row=mysqli_fetch_array($title)){
					$topic_title	= $row['topic_title'];
				}

				echo "	<p><img src='images/user_images/$user_image' width='100' height='100'></p>
						<br />
						<h3><a href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
						<h2>$post_title</h2>
						<p>($post_date)</p>
						<p><a href='single.php?post_id=$post_id'>$count_comments {$lang['COMMENTS']}</a></p>
						<div id='topics_button'>
							<a href='topics.php?topic=$topic_id'><button>$topic_title</button></a>
						</div>
						<br />
						<p>$post_content</p>
						<br />
						<div id='reply_button'>
							<a href='single.php?post_id=$post_id'><button>{$lang['REPLY_BUTTON']}</button></a>
						</div>
						<br />
						<br />
						<hr />";
			}

				$query = "select * from posts";
				$result = mysqli_query($con, $query);
				$total_posts = mysqli_num_rows($result);
				$total_pages = ceil($total_posts / $per_page);

				echo "<br /><center><div id='pagination'><a href='index.php?page=1'>{$lang['FIRST_PAGE_BUTTON']}</a>";
				for ($i=1; $i<=$total_pages; $i++) {
				echo "<a href='index.php?page=$i'>$i</a>";
				}
				echo "<a href='index.php?page=$total_pages'>{$lang['LAST_PAGE_BUTTON']}</a></div></center>";

		}

		# home.php
		function insertPost() {

		global $con;
		global $lang;

			$user			= $_SESSION['user_email'];
			$get_user 		= "select * from users where user_email='$user'";
			$run_user 		= mysqli_query($con, $get_user);
			$row			= mysqli_fetch_array($run_user);

			$user_id		= $row['user_id'];
			$user_name		= $row['user_name'];
			$user_image		= $row['user_image'];
			$user_country	= $row['user_country'];
			$last_login		= $row['last_login'];
			$register_date	= $row['register_date'];

					echo "	<form action='' method='post'>
							<input type='text' name='post_title' placeholder='{$lang['POSTS_FORM_TITLE_PLACEHOLDER']}' autocomplete='off' required='required'/>
							<br />
							<textarea type='text' name='post_content' placeholder='{$lang['POSTS_FORM_CONTENT_PLACEHOLDER']}' autocomplete='off' required='required'></textarea>
							<br />
							<select name='topic_id'>";

								$get_topics = "select * from topics";
								$run_topics = mysqli_query($con, $get_topics);

								while($row=mysqli_fetch_array($run_topics)){

								$topic_id		= $row['topic_id'];
								$topic_title	= $row['topic_title'];

					echo "	<option value='$topic_id'>$topic_title</a></option>";
								}

					echo "	</select>
							<button name='post'>{$lang['POST_BUTTON']}</button>
							</form>";

			if(isset($_POST['post'])){

				$title 		= htmlentities($_POST['post_title']);
				$content 	= htmlentities($_POST['post_content']);
				$topic_id 	= $_POST['topic_id'];

				$htmltext = BBcodesHTML($content);

				if($htmltext==''){
					echo "<div id='error'>{$lang['POST_TIMELINE_ERROR']}</div><br />";
					exit();
				}
				else  {

				$insert = "insert into posts (user_id, topic_id, post_title, post_content, post_date) values ('$user_id', '$topic_id', '$title', '$htmltext', NOW())";
				$run = mysqli_query($con, $insert);

					if($run){
						echo "<div id='success'>{$lang['POST_TIMELINE_SUCCESS']}</div><br />";
						$update = "update users set posts='yes' where user_id='$user_id'";
						$run_update = mysqli_query($con, $update);
						echo("<meta http-equiv='refresh' content='3'>");
					}
				}
			}
		}

		# single.php
		function singlePost(){

		global $con;
		global $lang;

			if(isset($_GET['post_id'])){
			$get_id = $_GET['post_id'];
			$get_posts = "select * from posts where post_id='$get_id'";
			$run_posts = mysqli_query($con, $get_posts);
			$row_posts=mysqli_fetch_array($run_posts);

				$post_id 		= $row_posts['post_id'];
				$topic_id 		= $row_posts['topic_id'];
				$user_id 		= $row_posts['user_id'];
				$post_title 	= $row_posts['post_title'];
				$post_content 	= $row_posts['post_content'];
				$post_date 		= $row_posts['post_date'];

				$user = "select * from users where user_id='$user_id' AND posts='yes'";

				$run_user 		= mysqli_query($con, $user);
				$row_user		= mysqli_fetch_array($run_user);
				$user_name 		= $row_user['user_name'];
				$user_image 	= $row_user['user_image'];

				$get_title = "select topic_title from topics where topic_id='$topic_id'";
				$title = mysqli_query($con, $get_title);

				$get_comments = "select * from comments where post_id='$post_id'";
				$run_comments = mysqli_query($con, $get_comments);
				$count_comments = mysqli_num_rows($run_comments);

				while($row=mysqli_fetch_array($title)){
					$topic_title = $row['topic_title'];
				}

				echo "	<p><img src='images/user_images/$user_image' width='100' height='100'></p>
						<br />
						<h2><a href='user_profile.php?u_id=$user_id'>$user_name</a></h2>
						<h3>$post_title <small>($post_date)</small></h3>
						<div id='topics_button'><a href='topics.php?topic=$topic_id'><button>$topic_title</button></a></div>
						<p>$count_comments {$lang['COMMENTS']}</p>
						<br />
						<p>$post_content</p>
						<br />";

				$get_id			= $_GET['post_id'];
				$get_com		= "select * from comments where post_id='$get_id' ORDER by 1 DESC";
				$run_comment	= mysqli_query($con, $get_com);

					while($row = mysqli_fetch_array($run_comment)){

						$com 		= $row['comment'];
						$com_author	= $row['comment_author'];
						$user_id	= $row['user_id'];
						$com_date 	= $row['date'];

						echo "	<hr />
								<p><img src='images/user_images/$user_image' width='40' height='40'></p>
								<h2><a href='user_profile.php?u_id=$user_id'>$com_author</a></h2>
								<p>$com_date</p>
								<br />
								<p>$com</p>
								<br />";
					}

				echo "	<form action='' method='post'>
						<textarea name='comment' placeholder='{$lang['COMMENTS_FORM_CONTENT_PLACEHOLDER']}' required='required' maxlength='2000'></textarea>
						<br />
						<button name='reply'>{$lang['POST_BUTTON']}</button>
						</form>";

				if(isset($_POST['reply'])){

					$comment = htmlentities($_POST['comment']);

					$htmltext = BBcodesHTML($comment);

					$insert	= "insert into comments (post_id, user_id, comment, comment_author, date) values ('$post_id', '$user_id', '$htmltext', '$user_name', NOW())";

					$run = mysqli_query($con, $insert);
					echo "<div id='success'>{$lang['POST_COMMENT_SUCCESS']}</div><br />";
					echo("<meta http-equiv='refresh' content='2'>");
				}
			}
		}

		# topics.php
		function showTopics(){

		global $con;
		global $lang;

			$per_page=5;

			if (isset($_GET['page'])){
			$page = $_GET['page'];
			}
			else {
			$page=1;
			}
			$start_from = ($page-1) * $per_page;

			if(isset($_GET['topic'])){
				$topic_id = $_GET['topic'];
			}

			$get_posts = "select * from posts where topic_id='$topic_id' ORDER by 1 DESC LIMIT $start_from, $per_page";
			$run_posts = mysqli_query($con,$get_posts);

			while($row_posts=mysqli_fetch_array($run_posts)){

				$post_id 		= $row_posts['post_id'];
				$topic_id 		= $row_posts['topic_id'];
				$user_id 		= $row_posts['user_id'];
				$post_title 	= $row_posts['post_title'];
				$post_content 	= $row_posts['post_content'];
				$post_date 		= $row_posts['post_date'];

				$user = "select * from users where user_id='$user_id' AND posts='yes'";

				$run_user 		= mysqli_query($con,$user);
				$row_user		= mysqli_fetch_array($run_user);
				$user_name 		= $row_user['user_name'];
				$user_image 	= $row_user['user_image'];

				$get_title = "select topic_title from topics where topic_id='$topic_id'";
				$title = mysqli_query($con, $get_title);

				$get_comments = "select * from comments where post_id='$post_id'";
				$run_comments = mysqli_query($con, $get_comments);
				$count_comments = mysqli_num_rows($run_comments);

				while($row=mysqli_fetch_array($title)){
					$topic_title	= $row['topic_title'];
				}

				echo "	<p><img src='images/user_images/$user_image' width='60' height='60'></p>
						<h2><a href='user_profile.php?u_id=$user_id'>$user_name</a></h2>
						<h3>$post_title <small>($post_date)</small></h3>
						<div id='topics_button'><a href='topics.php?topic=$topic_id'><button>$topic_title</button></a></div>
						<br />
						<p>$post_content</p>
						<br />
						<div id='reply_button'><a href='single.php?post_id=$post_id'><button>{$lang['REPLY_BUTTON']}</button></a></div>
						<br />
						<p><a href='single.php?post_id=$post_id'>$count_comments {$lang['COMMENTS']}</a></p>
						<hr />";
			}

				$query = "select * from posts";
				$result = mysqli_query($con, $query);
				$total_posts = mysqli_num_rows($result);
				$total_pages = ceil($total_posts / $per_page);

				echo "<br /><center><div id='pagination'><a href='topics.php?topic=$topic_id&page=1'>{$lang['FIRST_PAGE_BUTTON']}</a>";
				for ($i=1; $i<=$total_pages; $i++) {
				echo "<a href='topics.php?topic=$topic_id&page=$i'>$i</a>";
				}
				echo "<a href='topics.php?topic=$topic_id&page=$total_pages'>{$lang['LAST_PAGE_BUTTON']}</a></div></center>";

		}

		# search.php
		function searchResults(){

		global $con;
		global $lang;

			if(isset($_GET['user_query'])){
				$search_term = $_GET['user_query'];
			}

			$get_posts = "select * from posts where post_title LIKE '%$search_term%' ORDER by 1 DESC LIMIT 10";
			$run_posts = mysqli_query($con,$get_posts);

			$count_results = mysqli_num_rows($run_posts);

			if($count_results==0){
				echo "<div id='error'>{$lang['SEARCH_NO_RESULTS_ERROR']}</div><br />";
				exit;
			}

			if($search_term==''){
				echo "<div id='error'>{$lang['SEARCH_NO_QUERY_ERROR']}</div><br />";
				exit();
			}
			else  {

				while($row_posts=mysqli_fetch_array($run_posts)){

					$post_id 		= $row_posts['post_id'];
					$topic_id 		= $row_posts['topic_id'];
					$user_id 		= $row_posts['user_id'];
					$post_title 	= $row_posts['post_title'];
					$post_content 	= $row_posts['post_content'];
					$post_date 		= $row_posts['post_date'];

					$user = "select * from users where user_id='$user_id' AND posts='yes'";

					$run_user 		= mysqli_query($con,$user);
					$row_user		= mysqli_fetch_array($run_user);
					$user_name 		= $row_user['user_name'];
					$user_image 	= $row_user['user_image'];

					$get_title = "select topic_title from topics where topic_id='$topic_id'";
					$title = mysqli_query($con, $get_title);

					$get_comments = "select * from comments where post_id='$post_id'";
					$run_comments = mysqli_query($con, $get_comments);
					$count_comments = mysqli_num_rows($run_comments);

					while($row=mysqli_fetch_array($title)){
						$topic_title = $row['topic_title'];
					}

					echo "	<p><img src='images/user_images/$user_image' width='60' height='60'></p>
							<h2><a href='user_profile.php?u_id=$user_id'>$user_name</a></h2>
							<h3>$post_title <small>($post_date)</small></h3>
							<div id='topics_button'><a href='topics.php?topic=$topic_id'><button>$topic_title</button></a></div>
							<br />
							<p>$post_content</p>
							<br />
							<div id='reply_button'><a href='single.php?post_id=$post_id'><button>{$lang['REPLY_BUTTON']}</button></a></div>
							<br />
							<p><a href='single.php?post_id=$post_id'>$count_comments {$lang['COMMENTS']}</a></p>
							<hr />";
				}
			}
		}

		# userlist.php
		function userList(){

		global $con;

			$get_members = "select * from users";
			$run_members = mysqli_query($con,$get_members);

			while($row	= mysqli_fetch_array($run_members)){

			$user_id 		= $row['user_id'];
			$user_name 		= $row['user_name'];
			$user_image 	= $row['user_image'];
			$register_date 	= $row['register_date'];

				echo "	<p><img src='images/user_images/$user_image' width='50' height='50'></p>
						<br />
						<h3><a href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
						<p>$register_date</p>
						<br />
						<br />";
			}
		}

		# teams.php
		function getTeams(){

		global $con;

			$get_teams = "select * from teams;";
			$run_teams = mysqli_query($con,$get_teams);

			while($row	= mysqli_fetch_array($run_teams)){

			$team_id 		= $row['team_id'];
			$team_name 		= $row['team_name'];
			$team_desc 	= $row['description'];
			$profile_image 	= $row['profile_image'];
			if($profile_image==""){
				$profile_image='default.jpg';
			}

				echo "	<p><img src='images/team_images/$profile_image' width='50' height='50'></p>
						<br />
						<h3><a href='team.php?t_id=$team_id'>$team_name</a></h3>
						<p></p>
						<br /><br>
						<br />";
			}
		}
		# teams.php
		function getTeamMembers(){

		global $con;
		if(isset($_GET['t_id'])){
				$myId = $_SESSION['user_id'];
				$team_id = $_GET['t_id'];
				$iAmAdmin = false;
				$get_tms = "select user_name, user_email, users.user_id as user_id, role,
				first_name, last_name, user_image, team_id from team_members JOIN users ON team_members.user_id=users.user_id and team_id={$team_id}";
				$run_tms = mysqli_query($con,$get_tms);
				while($row = mysqli_fetch_array($run_tms)){
					if($row['user_id'] == $myId && $row['role'] == 1){
						$iAmAdmin = true;
					}
					$members[] = $row;
				}
				//print_r($members); exit(0);

				foreach($members as $row){

				$team_id 		= $row['team_id'];
				$user_name 		= $row['user_name'];
				$user_image 	= $row['user_image'];
				$user_id 	= $row['user_id'];
				$user_email 	= $row['user_email'];
				$first_name 	= $row['first_name'];
				$last_name 	= $row['first_name'];
				$role 	= $row['role'];
				if($user_image==""){
					$user_image='default.jpg';
				}
				$str = "	<p><img src='images/user_images/$user_image' width='50' height='50'></p>
						<br />
						<h3><a href='user_profile.php?u_id=$user_id'>$user_name</a>";
				if($role == 1){
					$str .= " <span class='small'>(Admin)</span>";
				}
				$str .= "</h3>";
				if($iAmAdmin && $user_id != $myId){
					$str .= "<div class='action-links'>
						<a href='remove_member.php?u_id={$user_id}&t_id=$team_id'>Remove</a>&nbsp;.&nbsp;<a href='make_member_admin.php?u_id={$user_id}&t_id=$team_id'>Make Admin</a>&nbsp;.&nbsp;
					</div>";
				} else if($user_id == $myId){
					$str .= "<div class='action-links'>
						<a>Leave Group</a>
					</div>";
				}
				$str .= "<p></p>
				<br /><br>
				<br />";
				echo $str;
				}
			}
		}

		#remove_member.php
		function removeTeamMember(){

			global $con;
			global $lang;

			if(isset($_GET['u_id']) && isset($_GET['t_id'])){
				$userId = $_GET['u_id'];
				$teamId = $_GET['t_id'];
				$myId = $_SESSION['user_id'];
				$get_role = "select role from team_members where user_id='$myId' and team_id='$teamId'";
				$run_role = mysqli_query($con, $get_role);
				if(mysqli_num_rows($run_role) == 1){
					$row_role=mysqli_fetch_array($run_role);
					if($row_role['role'] != 1){
						echo "<div id='error'>{$lang['NO_PERMISSION']}</div>";
						exit;
					}
				} else {
					echo "<div id='error'>{$lang['NO_PERMISSION']}</div>";
					exit;
				}
			}

				$get_user 		= "select * from users where user_id='$userId'";
				$run_user 		= mysqli_query($con, $get_user);
				$row			= mysqli_fetch_array($run_user);

				$user_name		= $row['user_name'];
				$user_image		= $row['user_image'];

			echo "	<p><img src='images/user_images/$user_image' width='60' height='60'></p>
					<h2 style='margin-top:10px;'>$user_name</h2><br>
					<h3>{$lang['MEMBER_REMOVE_CONFIRM']}</h3>
					<br />
					<form action='' method='post'
					<div id='delete_btn'><button name='delete'>{$lang['REMOVE_BUTTON']}</button></div>
					<div id='cancel_btn'><a href='team.php?t_id=$teamId'>{$lang['CANCEL_BUTTON']}</a></div>
					</form>
					<br />
					<br />";

			if(isset($_POST['delete'])){

				$remove_user = "delete from team_members where team_id='$teamId' and user_id='$userId'";
				$run_delete = mysqli_query($con, $remove_user);

				if($run_delete){
				echo "<div id='success'>{$lang['USER_REMOVED_FROM_TEAM']}</div><br />";
				echo("<meta http-equiv='refresh' content='3; URL=team.php?t_id=$teamId'>");
				}
			}
		}

		#make_member_admin.php
		function makeMemberAdmin(){

			global $con;
			global $lang;

			if(isset($_GET['u_id']) && isset($_GET['t_id'])){
				$userId = $_GET['u_id'];
				$teamId = $_GET['t_id'];
				$myId = $_SESSION['user_id'];
				$get_role = "select role from team_members where user_id='$myId' and team_id='$teamId'";
				$run_role = mysqli_query($con, $get_role);
				if(mysqli_num_rows($run_role) == 1){
					$row_role=mysqli_fetch_array($run_role);
					if($row_role['role'] != 1){
						echo "<div id='error'>{$lang['NO_PERMISSION']}</div>";
						exit;
					}
				} else {
					echo "<div id='error'>{$lang['NO_PERMISSION']}</div>";
					exit;
				}
			}

				$get_user 		= "select * from users where user_id='$userId'";
				$run_user 		= mysqli_query($con, $get_user);
				$row			= mysqli_fetch_array($run_user);

				$user_name		= $row['user_name'];
				$user_image		= $row['user_image'];

			echo "	<p><img src='images/user_images/$user_image' width='60' height='60'></p>
					<h2 style='margin-top:10px;'>$user_name</h2><br>
					<h3>{$lang['MEMBER_MAKEADMIN_CONFIRM']}</h3>
					<br />
					<form action='' method='post'
					<div id='delete_btn'><button name='delete'>{$lang['CONFIRM']}</button></div>
					<div id='cancel_btn'><a href='team.php?t_id=$teamId'>{$lang['CANCEL_BUTTON']}</a></div>
					</form>
					<br />
					<br />";

			if(isset($_POST['delete'])){

				$remove_user = "update team_members set role=1 where team_id='$teamId' and user_id='$userId'";
				$run_delete = mysqli_query($con, $remove_user);

				if($run_delete){
				echo "<div id='success'>{$lang['USER_MADE_ADMIN']}</div><br />";
				echo("<meta http-equiv='refresh' content='3; URL=team.php?t_id=$teamId'>");
				}
			}
		}

		# my_teams.php
		function getMyTeams(){

		global $con;
		$user			= $_SESSION['user_email'];
		$get_user 		= "select * from users where user_email='$user'";
		$run_user 		= mysqli_query($con, $get_user);
		$row			= mysqli_fetch_array($run_user);

		$user_id		= $row['user_id'];

			$get_teams = "select * from teams where creator_id={$user_id};";
			$run_teams = mysqli_query($con,$get_teams);

			while($row	= mysqli_fetch_array($run_teams)){

			$team_id 		= $row['team_id'];
			$team_name 		= $row['team_name'];
			$team_desc 	= $row['description'];
			$profile_image 	= $row['profile_image'];
			if($profile_image==""){
				$profile_image='default.jpg';
			}

				echo "	<p><img src='images/team_images/$profile_image' width='50' height='50'></p>
						<br />
						<h3><a href='team.php?t_id=$team_id'>$team_name</a></h3>
						<p></p>
						<br /><br>
						<br />";
			}
		}

		# searchusers.php
		function searchUsers(){

		global $con;
		global $lang;

			if(isset($_GET['user_query'])){
				$search_term = $_GET['user_query'];
			}

			$get_posts = "select * from users where user_name LIKE '%$search_term%' ORDER by 1 ASC LIMIT 10";
			$run_posts = mysqli_query($con,$get_posts);

			$count_results = mysqli_num_rows($run_posts);

			if($count_results==0){
				echo "<div id='error'>{$lang['SEARCH_NO_RESULTS_ERROR']}</div><br />";
				exit;
			}

			if($search_term==''){
				echo "<div id='error'>{$lang['SEARCH_NO_QUERY_ERROR']}</div><br />";
				exit();
			}
			else  {

				while($row_posts=mysqli_fetch_array($run_posts)){

					$user_id 		= $row_posts['user_id'];

					$user = "select * from users where user_id='$user_id'";

					$run_user 		= mysqli_query($con,$user);
					$row_user		= mysqli_fetch_array($run_user);
					$user_id 		= $row_posts['user_id'];
					$user_name 		= $row_user['user_name'];
					$user_image 	= $row_user['user_image'];

					echo "	<p><a href='user_profile.php?u_id=$user_id'><img src='images/user_images/$user_image' width='100' height='100'></a></p>
							<br />
							<h3><a href='user_profile.php?u_id=$user_id'>$user_name</a><h3>
							<div id='green_btn'>
								<a href='send_message.php?u_id=$user_id'><button>Private Message</button></a>
							</div>
							<div id='blue_btn'>
								<a href='user_profile.php?u_id=$user_id'><button>View Posts</button></a>
							</div>
							<br/>
							<br />
							<hr />";
				}
			}
		}

		# user_profile.php
		function userProfile(){

		global $con;
		global $lang;

			if(isset($_GET['u_id'])){

				$user_id = $_GET['u_id'];

				$select = "select * from users where user_id='$user_id'";
				$run = mysqli_query($con,$select);
				$row=mysqli_fetch_array($run);

				$user_id		= $row['user_id'];
				$image 			= $row['user_image'];
				$name		 	= $row['user_name'];
				$country 		= $row['user_country'];
				$gender 		= $row['user_gender'];
				$last_login 	= $row['last_login'];
				$register_date	= $row['register_date'];

				echo "	<p><img src='images/user_images/$image' width='100' height='100' /></p>
						<br />
						<p><b>Name:</b> $name </p>
						<p><b>Gender:</b> $gender</p>
						<p><b>Country:</b> $country </p>
						<p><b>Last Login:</b> $last_login </p>
						<p><b>Member Since:</b> $register_date</p>
						<a href='send_message.php?u_id=$user_id'><button>{$lang['SEND_MSG']}</button></a>";
			}
		}

		#team.php
		function teamProfile(){

		global $con;
		global $lang;

			if(isset($_GET['t_id'])){

				$team_id = $_GET['t_id'];

				$select = "select * from teams where team_id='$team_id'";
				$run = mysqli_query($con,$select);
				$row=mysqli_fetch_array($run);

				$team_id		= $row['team_id'];
				$image 			= $row['profile_image'];
				$name		 	= $row['team_name'];
				$description 		= $row['description'];
				$inviteLink = "http://wesl.one/jointeam.php?t_id={$team_id}";
				if($image == ''){
					$image = "default.jpg";
				}

				echo "	<p class='clearfix'><img src='images/team_images/$image' width='100' height='100' /></p>
						<br />
						<p><h3><b>$name</b></h3> </p>
						<p>Invite Link: $inviteLink</p><br>
						<p>$description</p><br>
						<a href='edit_team.php?t_id=$team_id'><button>{$lang['EDIT_TEAM']}</button></a>";
			}
		}

		# user_profile.php
		function userProfilePosts(){

		global $con;
		global $lang;

			#$per_page=5;
			#
			#if (isset($_GET['page'])){
			#$page = $_GET['page'];
			#}
			#else {
			#$page=1;
			#}
			#$start_from = ($page-1) * $per_page;

			if(isset($_GET['u_id'])){
				$u_id = $_GET['u_id'];
			}

			$get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC";
			$run_my_posts = mysqli_query($con, $get_posts);

			while($row_posts=mysqli_fetch_array($run_my_posts)){

				$post_id 		= $row_posts['post_id'];
				$topic_id 		= $row_posts['topic_id'];
				$user_id 		= $row_posts['user_id'];
				$post_title 	= $row_posts['post_title'];
				$post_content 	= $row_posts['post_content'];
				$post_date 		= $row_posts['post_date'];

				$user = "select * from users where user_id='$user_id'";

				$run_user 		= mysqli_query($con, $user);
				$row_user		= mysqli_fetch_array($run_user);
				$user_name 		= $row_user['user_name'];
				$user_image 	= $row_user['user_image'];

				$get_title = "select topic_title from topics where topic_id='$topic_id'";
				$title = mysqli_query($con, $get_title);

				$get_comments = "select * from comments where post_id='$post_id'";
				$run_comments = mysqli_query($con, $get_comments);
				$count_comments = mysqli_num_rows($run_comments);

				while($row=mysqli_fetch_array($title)){
					$topic_title	= $row['topic_title'];
				}

					echo "	$user_posts<p><img src='images/user_images/$user_image' width='60' height='60'></p>
							<h2><a href='user_profile.php?u_id=$user_id'>$user_name</a></h2>
							<h3>$post_title <small>($post_date)</small></h3>
							<div id='topics_button'><a href='topics.php?topic=$topic_id'><button>$topic_title</button></a></div>
							<br />
							<p>$post_content</p>
							<br />
							<div id='reply_button'><a href='single.php?post_id=$post_id'><button>{$lang['REPLY_BUTTON']}</button></a></div>
							<br />
							<p><a href='single.php?post_id=$post_id'>$count_comments {$lang['COMMENTS']}</a></p>
							<hr />";
			}

				#$query = "select * from posts where user_id='$u_id'";
				#$result = mysqli_query($con, $query);
				#$total_posts = mysqli_num_rows($result);
				#$total_pages = ceil($total_posts / $per_page);
				#
				#echo "<br /><center><div id='pagination'><a href='my_posts.php?page=1'>{$lang['FIRST_PAGE_BUTTON']}</a>";
				#for ($i=1; $i<=$total_pages; $i++) {
				#echo "<a href='my_posts.php?page=$i'>$i</a>";
				#}
				#echo "<a href='my_posts.php?page=$total_pages'>{$lang['LAST_PAGE_BUTTON']}</a></div></center>";

		}

		# edit_profile.php
		function updateUser(){

		global $con;
		global $lang;

			$user			= $_SESSION['user_email'];
			$get_user 		= "select * from users where user_email='$user'";
			$run_user 		= mysqli_query($con, $get_user);
			$row			= mysqli_fetch_array($run_user);

			$user_id		= $row['user_id'];
			$user_name		= $row['user_name'];
			$user_status	= $row['status'];
			$user_pass		= $row['user_pass'];
			$first_name		= $row['first_name'];
			$last_name		= $row['last_name'];
			$user_email		= $row['user_email'];
			$user_country	= $row['user_country'];
			$user_gender	= $row['user_gender'];
			$user_bday		= $row['user_bday'];
			$user_image		= $row['user_image'];
			$twitch_name	= $row['twitch'];
			$xbox_name		= $row['xbox'];
			$psn_name		= $row['psn'];
			$profile_msg	= $row['profile_msg'];

			echo "	<form action='' method='post' enctype='multipart/form-data'>
					<table>
						<tr>
							<td>Language:</td>
							<td><div id='href_btn'><a href='?lang=en'>English</a> <a href='?lang=de'>Deutsch</a></div></td>
						</tr>
						<tr>
							<td>Username:</td>
							<td><div id='readonly'><input type='text' name='u_name' value='$user_name' readonly='readonly'/></div></td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><div id='readonly'><input type='email' name='u_email' value='$user_email' readonly='readonly'/></div></td>
						</tr>
						<tr>
							<td>Status:</td>
							<td>$user_status</td>
						</tr>
						<tr>
							<td>Password:</td>
							<td><input type='password' name='u_pass' value='$user_pass'/></td>
						</tr>
						<tr>
							<td>Repeat Password:</td>
							<td><input type='password' name='u_pass2' value='$user_pass'/></td>
						</tr>
						<tr>
							<td>First Name:</td>
							<td><input type='text' name='first_name' value='$first_name' maxlength='50'/></td>
						</tr>
						<tr>
							<td>Last Name:</td>
							<td><input type='text' name='last_name' value='$last_name' maxlength='50'/></td>
						</tr>
						<tr>
							<td>Country:</td>
							<td>
								<select name='u_country' value='$user_country'/>
									<option selected='$user_country'>$user_country</option>
									<option>Germany</option>
									<option>United States</option>
									<option>...</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Gender:</td>
							<td>
								<select name='u_gender'/>
									<option selected='$user_gender'>$user_gender</option>
									<option>Male</option>
									<option>Female</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Birth Date:</td>
							<td>
								<div id='date'><input type='date' name='u_bday' value='$user_bday'/></div>
							</td>
						</tr>
						<tr>
							<td>Profile Image:</td>
							<td>
								<div id='file'><input type='file' name='u_image' value='$user_image'/></div>
							</td>
						</tr>
						<tr>
							<td>Twitch.tv:</td>
							<td><input type='text' name='twitch_name' value='$twitch_name' maxlength='50'/></td>
						</tr>
						<tr>
							<td>XBOX Live:</td>
							<td><input type='text' name='xbox_name' value='$xbox_name' maxlength='50'/></td>
						</tr>
						<tr>
							<td>PlayStation Network:</td>
							<td><input type='text' name='psn_name' value='$psn_name' maxlength='50'/></td>
						</tr>
						<tr>
							<td>Profile Message:</td>
							<td><textarea type='text' name='profile_msg' maxlength='200'>$profile_msg</textarea></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<button name='update'>{$lang['UPDATE_PROFILE']}</button>
							</td>
						</tr>
					</table>
				</form>
				<br />";

			if(isset($_POST['update'])){

				$u_pass 		= $_POST['u_pass'];
				$u_pass2 		= $_POST['u_pass2'];
				$first_name 	= htmlentities($_POST['first_name']);
				$last_name 		= htmlentities($_POST['last_name']);
				$u_country 		= $_POST['u_country'];
				$u_gender 		= $_POST['u_gender'];
				$u_bday 		= $_POST['u_bday'];
				$u_image 		= $_FILES['u_image']['name'];
				$image_tmp 		= $_FILES['u_image']['tmp_name'];
				$twitch_name 	= htmlentities($_POST['twitch_name']);
				$xbox_name 		= htmlentities($_POST['xbox_name']);
				$psn_name 		= htmlentities($_POST['psn_name']);
				$profile_msg	= htmlentities($_POST['profile_msg']);

				$htmltext = BBcodesHTML($profile_msg);

				move_uploaded_file($image_tmp,"images/user_images/$u_image");

				if($u_pass != $u_pass2){
					echo "<div id='error'>{$lang['PROFILE_UPDATE_ERROR1']}</div><br />";
					exit;
				}

				if(strlen($u_pass)<6){
				echo "<div id='error'>{$lang['PROFILE_UPDATE_ERROR2']}</div><br />";
				exit();
				}

				else {

				if(empty($_FILES['u_image']['name'])){
					$u_image = $user_image;
				}

					$update = "update users set user_pass='$u_pass', first_name='$first_name', last_name='$last_name', twitch='$twitch_name', xbox='$xbox_name', psn='$psn_name', profile_msg='$htmltext', user_country='$u_country', user_gender='$u_gender', user_bday='$u_bday', user_image='$u_image' where user_id='$user_id'";

					$run = mysqli_query($con, $update);

					if($run){

						echo "<div id='success'>{$lang['PROFILE_UPDATE_SUCCESS']}</div><br />";
						echo("<meta http-equiv='refresh' content='2'>");
					}
				}
			}
		}

		# create_team.php
		function createTeam(){

		global $con;
		global $lang;

			$user			= $_SESSION['user_email'];
			$get_user 		= "select * from users where user_email='$user'";
			$run_user 		= mysqli_query($con, $get_user);
			$row			= mysqli_fetch_array($run_user);

			$user_id		= $row['user_id'];

			echo "	<form action='' method='post' enctype='multipart/form-data'>
					<table>
						<tr>
							<td>Team Name:</td>
							<td><div><input type='text' name='t_name'/></div></td>
						</tr>
						<tr>
							<td>Description:</td>
							<td><textarea type='text' name='team_desc_content' autocomplete='off' required='required'></textarea></td>
						</tr>
						<tr>
							<td>Profile Image:</td>
							<td>
								<div id='file'><input type='file' name='t_image' value=''/></div>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<button name='create'>{$lang['CREATE_TEAM']}</button>
							</td>
						</tr>
					</table>
				</form>
				<br />";

			if(isset($_POST['create'])){

				$team_name 	= htmlentities($_POST['t_name']);
				$team_desc 		= htmlentities($_POST['team_desc_content']);
				$t_image 		= $_FILES['t_image']['name'];
				$image_tmp 		= $_FILES['t_image']['tmp_name'];

				move_uploaded_file($image_tmp,"images/team_images/$t_image");

				if(empty($_FILES['t_image']['name'])){
					$t_image = "";
				}

				$create = "insert into teams (team_name, description, creator_id, created_at, profile_image) values ('$team_name', '$team_desc', '$user_id',NOW(), '$t_image')";
				//echo $create; exit(0);
				$run = mysqli_query($con, $create);
				$teamId = mysqli_insert_id($con);
				if($run){
					$addMember = "insert into team_members (user_id, team_id, created_at, role) values ('$user_id', '$teamId',NOW(), 1)";
					//echo $create; exit(0);
					$run = mysqli_query($con, $addMember);

					echo "<div id='success'>{$lang['CREATE_TEAM_SUCCESS']}</div><br />";
					echo("<meta http-equiv='refresh' content='2'>");
				}

			}
		}

		# update_team.php
		function updateTeam(){

		global $con;
		global $lang;
		if(isset($_GET['t_id'])){
			$team_id = $_GET['t_id'];
			$user			= $_SESSION['user_email'];
			$get_user 		= "select * from users where user_email='$user'";
			$run_user 		= mysqli_query($con, $get_user);
			$row			= mysqli_fetch_array($run_user);
			$user_id		= $row['user_id'];

			$get_team 		= "select * from teams where team_id='$team_id' and creator_id='$user_id'";
			$run_team 		= mysqli_query($con, $get_team);
			$row			= mysqli_fetch_array($run_team);

			$team_id = $row['team_id'];
			$team_name = $row['team_name'];
			$team_desc = $row['description'];
			$profile_image = $row['profile_image'];

			echo "	<form action='' method='post' enctype='multipart/form-data'>
					<table>
						<tr>
							<td>Team Name:</td>
							<td><div><input type='text' name='t_name' value='{$team_name}'/></div></td>
						</tr>
						<tr>
							<td>Description:</td>
							<td><textarea type='text' name='team_desc_content' autocomplete='off' required='required'>{$team_desc}</textarea></td>
						</tr>
						<tr>
							<td>Profile Image:</td>
							<td>
								<div id='file'><input type='file' name='t_image' value=''/></div>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<button name='update'>{$lang['UPDATE_TEAM']}</button>
							</td>
						</tr>
					</table>
				</form>
				<br />";
			}
			if(isset($_POST['update'])){

				$team_name 	= htmlentities($_POST['t_name']);
				$team_desc 		= htmlentities($_POST['team_desc_content']);
				$t_image 		= $_FILES['t_image']['name'];
				$image_tmp 		= $_FILES['t_image']['tmp_name'];

				move_uploaded_file($image_tmp,"images/team_images/$t_image");

				if(empty($_FILES['t_image']['name'])){
					$t_image = $profile_image;
				}

				$update = "update teams set team_name='$team_name', description='$team_desc', updated_at=NOW(), profile_image='$t_image' where team_id='$team_id' and creator_id='$user_id'";
				//echo $update; exit(0);
				$run = mysqli_query($con, $update);

				if($run){

					echo "<div id='success'>{$lang['UPDATE_TEAM_SUCCESS']}</div><br />";
					echo("<meta http-equiv='refresh' content='2'>");
				}

			}
		}

		function deletePost(){

			global $con;
			global $lang;

			if(isset($_GET['post_id'])){
			$get_post = $_GET['post_id'];

			$get_post = "select * from posts where post_id='$get_post'";
			$run_posts = mysqli_query($con, $get_post);
			$row_posts=mysqli_fetch_array($run_posts);

				$author 		= $row_posts['user_id'];
				$post_title 	= $row_posts['post_title'];
				$topic_id 		= $row_posts['topic_id'];
				$post_id	 	= $row_posts['post_id'];
				$post_date		= $row_posts['post_date'];
				$post_content	= $row_posts['post_content'];
			}

					$user			= $_SESSION['user_email'];
					$get_user 		= "select * from users where user_email='$user'";
					$run_user 		= mysqli_query($con, $get_user);
					$row			= mysqli_fetch_array($run_user);

					$user_id		= $row['user_id'];
					$user_name		= $row['user_name'];
					$user_image		= $row['user_image'];

				$get_title = "select topic_title from topics where topic_id='$topic_id'";
				$title = mysqli_query($con, $get_title);

				while($row=mysqli_fetch_array($title)){
					$topic_title = $row['topic_title'];
				}

			if($author != $user_id){
			echo "<div id='error'>{$lang['POST_DELETE_ERROR']}</div>";
			exit;
			}

			echo "	<p><img src='images/user_images/$user_image' width='60' height='60'></p>
					<h2><a href='user_profile.php?u_id=$user_id'>$user_name</a></h2>
					<h3>$post_title <small>($post_date)</small></h3>
					<div id='topics_button'><a href='topics.php?topic=$topic_id'><button>$topic_title</button></a></div>
					<br />
					<p>$post_content</p>
					<br />
					<form action='' method='post'
					<div id='delete_btn'><button name='delete'>{$lang['DELETE_BUTTON']}</button></div>
					<div id='cancel_btn'><a href='single.php?post_id=$post_id'>{$lang['CANCEL_BUTTON']}</a></div>
					</form>
					<br />
					<br />";

			if(isset($_POST['delete'])){

				$delete_post = "delete from posts where post_id='$post_id'";
				$run_delete = mysqli_query($con, $delete_post);

				if($run_delete){
				echo "<div id='success'>{$lang['POST_DELETE_SUCCESS']}</div><br />";
				echo("<meta http-equiv='refresh' content='3; URL=my_posts.php?u_id=$user_id'>");
				}
			}
		}

		function editPost(){

		global $con;
		global $lang;

			if(isset($_GET['post_id'])){

				$post_id = $_GET['post_id'];

				$post_id 	= "select * from posts where post_id='$post_id'";
				$run_post 	= mysqli_query($con, $post_id);
				$row		= mysqli_fetch_array($run_post);

				$author			= $row['user_id'];
				$post_id		= $row['post_id'];
				$topic			= $row['topic_id'];
				$post_title		= $row['post_title'];
				$post_content	= $row['post_content'];

				$bbtext = HTMLBBcodes($post_content);

			}
					$user			= $_SESSION['user_email'];
					$get_user 		= "select * from users where user_email='$user'";
					$run_user 		= mysqli_query($con, $get_user);
					$row			= mysqli_fetch_array($run_user);

					$user_id		= $row['user_id'];

				$get_title = "select topic_title from topics where topic_id='$topic'";
				$title = mysqli_query($con, $get_title);

				while($row=mysqli_fetch_array($title)){
					$topic_title = $row['topic_title'];
				}

			if($author != $user_id){
				echo "<div id='error'>{$lang['POST_DELETE_ERROR']}</div>";
				exit;
			}

					echo "	<form action='' method='post'>
							<input type='text' name='post_title' value='$post_title' autocomplete='off' required='required'/>
							<br />
							<textarea type='text' name='post_content' autocomplete='off' required='required' maxlength='2000'>$bbtext</textarea>
							<br />
							<select name='topic_id'>
								<option selected='$topic_title'>$topic_title</option>";

								$get_topics = "select * from topics";
								$run_topics = mysqli_query($con, $get_topics);

								while($row=mysqli_fetch_array($run_topics)){

								$topic_id		= $row['topic_id'];
								$topic_title	= $row['topic_title'];

					echo "	<option value='$topic_id'>$topic_title</a></option>";
								}

					echo "	</select>
							<button name='update'>{$lang['UPDATE_BUTTON']}</button>
							</form>
							<br />
							<br />";

			if(isset($_POST['update'])){

				$post_title		= htmlentities($_POST['post_title']);
				$post_content 	= htmlentities($_POST['post_content']);
				$topic_id 		= $_POST['topic_id'];

				$htmltext = BBcodesHTML($post_content);

				if($topic_id == 0){
					$topic_id = $topic;
				}

				$update_post = "update posts set post_title='$post_title', post_content='$htmltext', topic_id='$topic_id' where post_id='$post_id'";
				$run_update = mysqli_query($con, $update_post);

				if($run_update){

					echo "<meta http-equiv='refresh' content='3, URL=single.php?post_id=$post_id'/>";
					echo "<div id='success'>{$lang['POST_UPDATE_SUCCESS']}</div><br />";
				}
			}
		}

		# send_message.php
		function sendMessage(){

		global $con;
		global $lang;

			if(isset($_GET['u_id'])){

				$u_id = $_GET['u_id'];

				$select_user = "select * from users where user_id='$u_id'";
				$run = mysqli_query($con, $select_user);
				$row = mysqli_fetch_array($run);

					$user_name 		= $row['user_name'];
					$user_image 	= $row['user_image'];

					$user		= $_SESSION['user_email'];
					$get_user 	= "select * from users where user_email='$user'";
					$run_user 	= mysqli_query($con, $get_user);
					$row		= mysqli_fetch_array($run_user);

						$user_id = $row['user_id'];

					if(empty($user_name)){
						echo "<div id='error'>{$lang['SEND_MESSAGE_ERROR1']}</div><br />";
						exit;
					}

					if($u_id == $user_id){
						echo "<div id='error'>{$lang['SEND_MESSAGE_ERROR2']}</div><br />";
						exit;
					}
			}

			echo "	<img src='images/user_images/$user_image' width='80' height='80'/>
					<form action='' method='post'>
						<div id='readonly'>
							<input type='text' name='user_name' value='$user_name' readonly='readonly'/>
						</div>
						<input type='text' name='msg_subject' placeholder='Message Subject' autocomplete='off' required='required'/>
						<br />
						<br />
						<textarea style='margin-left:80px;' name='msg_content' placeholder='Message Content' autocomplete='off' required='required' maxlength='2000'/></textarea>
						<br/>
						<button style='margin-left:80px;' name='send_msg'>Send Message</button>
					</form>
					<br />";

			if(isset($_POST['send_msg'])){

				$msg_subject 	= htmlentities($_POST['msg_subject']);
				$msg_content	= htmlentities($_POST['msg_content']);

				$htmltext = BBcodesHTML($msg_content);

				$insert = "insert into messages (sender_id, receiver_id, msg_subject, msg_content, status, msg_date) values ('$user_id', '$u_id', '$msg_subject', '$htmltext', 'unread', NOW())";

				$run_insert = mysqli_query($con, $insert);

				if($run_insert){
					echo "<div id='success'>{$lang['SEND_MESSAGE_SUCCESS']} $user_name</div></br />";
				}
				else {
					echo "<div id='error'>{$lang['SEND_MESSAGE_ERROR3']}</div><br />";
				}
			}
		}

		# my_messages.php
		function messagesInbox(){

		global $con;
		global $lang;

			echo "	<table width='100%'>
					<tr>
						<th>Sender</th>
						<th>Receiver</th>
						<th>Subject</th>
						<th>Date</th>
						<th>Status</th>
					</tr>";

			$user		= $_SESSION['user_email'];
			$get_user 	= "select * from users where user_email='$user'";
			$run_user 	= mysqli_query($con, $get_user);
			$row		= mysqli_fetch_array($run_user);

				$user_id = $row['user_id'];

			$select_msgs = "select * from messages where receiver_id='$user_id' ORDER by 1 DESC";
			$run_msgs = mysqli_query($con, $select_msgs);

			$count_msgs = mysqli_num_rows($run_msgs);

			while($row_msgs = mysqli_fetch_array($run_msgs)){

				$msg_id 		= $row_msgs['msg_id'];
				$sender_id 		= $row_msgs['sender_id'];
				$receiver_id 	= $row_msgs['receiver_id'];
				$msg_subject 	= $row_msgs['msg_subject'];
				$msg_content 	= $row_msgs['msg_content'];
				$msg_status 	= $row_msgs['status'];
				$msg_date 		= $row_msgs['msg_date'];

				if($msg_status == "unread"){
					$msg_status = $lang['MSG_STATUS_UNREAD'];
					$msg_subject = "<b>$msg_subject</b>";
				}

				if($msg_status == "read"){
					$msg_status = $lang['MSG_STATUS_READ'];
				}
				if($msg_status == "reply"){
					$msg_status = $lang['MSG_STATUS_REPLY'];
				}

				$get_sender	= "select * from users where user_id='$sender_id'";
				$run_sender		= mysqli_query($con, $get_sender);
				$row			= mysqli_fetch_array($run_sender);

				$sender_name 	= $row['user_name'];

				$get_receiver	= "select * from users where user_id='$receiver_id'";
				$run_receiver	= mysqli_query($con, $get_receiver);
				$row			= mysqli_fetch_array($run_receiver);

				$receiver_name = $row['user_name'];

			echo "	<tr>
						<td><a href='user_profile.php?u_id=$sender_id'>$sender_name</a></td>
						<td><a href='user_profile.php?u_id=$receiver_id'>$receiver_name</a></td>
						<td><a href='messages.php?msg_id=$msg_id'>$msg_subject</a></td>
						<td>$msg_date</td>
						<td>$msg_status</td>
					</tr>";
			}
			echo "	</table>";
		}

		# my_messages.php
		function messagesOutbox(){

		global $con;
		global $lang;

			echo "	<table width='100%'>
					<tr>
						<th>Sender</th>
						<th>Receiver</th>
						<th>Subject</th>
						<th>Date</th>
						<th>Status</th>
					</tr>";

			$user		= $_SESSION['user_email'];
			$get_user 	= "select * from users where user_email='$user'";
			$run_user 	= mysqli_query($con, $get_user);
			$row		= mysqli_fetch_array($run_user);

				$user_id 		= $row['user_id'];

			$select_msgs = "select * from messages where sender_id='$user_id'";
			$run_msgs = mysqli_query($con, $select_msgs);

			$count_msgs = mysqli_num_rows($run_msgs);

			while($row_msgs = mysqli_fetch_array($run_msgs)){

				$msg_id 		= $row_msgs['msg_id'];
				$sender_id 		= $row_msgs['sender_id'];
				$receiver_id 	= $row_msgs['receiver_id'];
				$msg_subject 	= $row_msgs['msg_subject'];
				$msg_content 	= $row_msgs['msg_content'];
				$msg_status 	= $row_msgs['status'];
				$msg_date 		= $row_msgs['msg_date'];

				if($msg_status == "unread"){
					$msg_status = $lang['MSG_STATUS_UNREAD'];
				}

				if($msg_status == "read"){
					$msg_status = $lang['MSG_STATUS_READ'];
				}
				if($msg_status == "reply"){
					$msg_status = $lang['MSG_STATUS_REPLY'];
				}

				$get_sender	= "select * from users where user_id='$sender_id'";
				$run_sender	= mysqli_query($con, $get_sender);
				$row		= mysqli_fetch_array($run_sender);

				$sender_name = $row['user_name'];

				$get_receiver	= "select * from users where user_id='$receiver_id'";
				$run_receiver	= mysqli_query($con, $get_receiver);
				$row			= mysqli_fetch_array($run_receiver);

				$receiver_name = $row['user_name'];

			echo "	<tr>
						<td><a href='user_profile.php?u_id=$sender_id'>$sender_name</a></td>
						<td><a href='user_profile.php?u_id=$receiver_id'>$receiver_name</a></td>
						<td><a href='messages.php?msg_id=$msg_id'>$msg_subject</a></td>
						<td>$msg_date</td>
						<td>$msg_status</td>
					</tr>";
			}
			echo "	</table>";
		}

		# messages.php
		function showMessage(){

		global $con;
		global $lang;

			if(isset($_GET['msg_id'])){

					$get_id = $_GET['msg_id'];

					$select_msg = "select * from messages where msg_id='$get_id'";
					$run_msg = mysqli_query($con, $select_msg);

					$row_msg = mysqli_fetch_array($run_msg);

					$sender_id 		= $row_msg['sender_id'];
					$receiver_id 	= $row_msg['receiver_id'];
					$msg_subject 	= $row_msg['msg_subject'];
					$msg_content 	= $row_msg['msg_content'];
					$status 		= $row_msg['status'];

					$get_sender	= "select * from users where user_id='$sender_id'";
					$run_sender		= mysqli_query($con, $get_sender);
					$row			= mysqli_fetch_array($run_sender);

					$sender_name 	= $row['user_name'];

					$user		= $_SESSION['user_email'];
					$get_user 	= "select * from users where user_email='$user'";
					$run_user 	= mysqli_query($con, $get_user);
					$row		= mysqli_fetch_array($run_user);

						$user_id 	= $row['user_id'];
						$user_name 	= $row['user_name'];

					if($receiver_id != $user_id){
						echo "<div id='error'>{$lang['SHOW_MESSAGE_ERROR1']}</div><br />";
						exit;
					}

					echo "	<div id='msg'>
							<p><a href='user_profile.php?u_id=$sender_id'><b>$sender_name</b></a></p>
							<h3>$msg_subject</h3>
							<hr />
							<br />
							<p>$msg_content</p>
							<br />
							</div>
							<br />";

					if($status != "reply"){

						$set_read = "update messages set status='read' where msg_id='$get_id'";
						$run_read = mysqli_query($con, $set_read);

						echo "	<form action='' method='post'>
									<input type='text' name='msg_subject' value='RE: $msg_subject'/>
									<br />
									<textarea name='msg_content' placeholder='Reply Content' autocomplete='off' required='required' maxlength='2000'></textarea>
									<br />
									<button name='msg_reply'>Reply</button>
								</form>";
					}

				if(isset($_POST['msg_reply'])){

					$msg_subject	= htmlentities($_POST['msg_subject']);
					$msg_content	= htmlentities($_POST['msg_content']);

					$htmltext = BBcodesHTML($msg_content);

					$insert = "insert into messages (sender_id, receiver_id, msg_subject, msg_content, status, msg_date) values ('$user_id', '$sender_id', '$msg_subject', '$htmltext', 'unread', NOW())";
					$run_insert = mysqli_query($con, $insert);
					$update = "update messages set status='reply' where msg_id='$get_id'";
					$run_update = mysqli_query($con, $update);

					if($run_insert){
						echo "<div id='success'>{$lang['SEND_MESSAGE_SUCCESS']} $sender_name</div></br />";
					}
					else {
						echo "<div id='error'>{$lang['SEND_MESSAGE_ERROR3']}</div><br />";
					}
				}
			}
		}

		#jointeam.php
		function addUserInTeam($teamId){
			global $con;
			global $lang;

			$user		= $_SESSION['user_email'];
			$get_user 	= "select * from users where user_email='$user'";
			$run_user 	= mysqli_query($con, $get_user);
			$row		= mysqli_fetch_array($run_user);

			$user_id 	= $row['user_id'];

			$get_team 	= "select * from teams where team_id='$teamId'";
			$run_team 	= mysqli_query($con, $get_team);
			if(mysqli_num_rows($run_team) == 1){
				$get_member 	= "select * from team_members where team_id='$teamId' and user_id='$user_id';";
				$run_member 	= mysqli_query($con, $get_member);
				if(mysqli_num_rows($run_member) == 1){
					echo "<div id='error'>{$lang['ALLREADY_IN_TEAM']}</div><br />";
				} else {
					$insert = "insert into team_members (user_id, team_id, created_at, role) values ('$user_id', '$teamId', NOW(), 0)";
					$run_insert = mysqli_query($con, $insert);
					if($run_insert){
						header("Location: team.php?t_id={$teamId}&just_joined=1");
					}
					else {
						echo "<div id='error'>{$lang['MESSAGE_INVALID_LINK']}</div><br />";
					}
				}
			} else {
				echo "<div id='error'>{$lang['MESSAGE_INVALID_LINK']}</div><br />";
			}
		}

		function test(){

			echo "TEST";
		}
?>
