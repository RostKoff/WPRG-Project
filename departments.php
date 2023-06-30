<?php include('header.html'); ?>
	<title>Departments</title>
</head>
<body>
	<?php
		require_once('php/classes/user.php');
		require_once('php/classes/page_content_manager.php');
		require_once('php/classes/user_dao.php');
		require_once('php/classes/database_connection.php');
		require_once('php/classes/departments_dao.php');
		session_start();
		page_content_manager::define_user_type();
		$user_dao = new user_dao(database_connection::get_instance()->get_resource());
		$users = $user_dao->get_all_users();
	?>
	<div class="container-fluid">
		<div class="row">
			<?php include('sidebar.php'); ?>
			<div class="col">
				<div class="container">
					<h1 class="text-center">Departments</h1>
					<?php include('php/scripts/add_department.php') ?>
					<div class="row pt-3">
						<?php
						$departments_dao = new departments_dao(database_connection::get_instance()->get_resource());
						if(($departments = $departments_dao->get_departments()) !== false && sizeof($departments) != 0)
							foreach($departments as $department):
						?>
						<div class="col-4 p-2">
							<div class="w-100 green-block dropend green-hover text-center py-5 position-relative">
								<div class="w-100 d-flex mb-3">
									<svg class="mx-auto" width="80" height="80" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
										<image height="25" width="25" xlink:href="https://ui-avatars.com/api/?&name=<?php echo str_replace(' ', '+', $department["title"]) ?>&background=random&length=3&format=svg"></image>
									</svg>
								</div>
								<h4><?php echo $department['title'] ?></h4>
								<a href="calendar.php?id=<?php echo $department['id'] ?>" class="">
									<span class="z-1 w-100 h-100 top-50 left-50 translate-middle position-absolute"></span>
								</a>
								<button data-bs-toggle="dropdown" aria-expanded="false" class="z-2 position-absolute end-0 top-0 me-2 mt-2 p-0">
									<span class="">
										<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
											<use xlink:href="images/icons/dots-horizontal.svg#id"></use>
										</svg>
									</span>
								</button>
								<ul class="drop-menu dropdown-menu">
									<li class="px-2 position-relative py-1 green-hover">Open “Backlog” page<a href=""><span class="position-absolute top-50 start-50 w-100 h-100 translate-middle"></span></a></li>
									<li class="px-2 position-relative py-1 green-hover">Open “Users” page<a href=""><span class="position-absolute top-50 start-50 w-100 h-100 translate-middle"></span></a></li>

										<li class="px-2 d-flex py-1 mt-2">
											<form class="mx-auto" action="request_to_join.php" method="POST"><input
													type="hidden" name="department_id" value="<?php echo $department['id'] ?>"><button class=" action-button">Request to join</button></form>
										</li>
								</ul>
							</div>
						</div>
						<?php endforeach; ?>
						<?php if(USER_TYPE === user_type::ADMIN): ?>
						<div class="col-4 p-2">
								<button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="w-100 h-100 add-department py-5"><h4>Add Department</h4></button>
						</div>

						<!-- Modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content green-block">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Create new department</h5>
										<svg type="button" data-bs-dismiss="modal" aria-label="Close" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
											<use xlink:href="images/icons/close.svg#id"></use>
										</svg>
									</div>
									<div class="modal-body">
										<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
											<label for="dep_name">Department name</label><br>
											<input id="dep_name" name="dep_name" type="text" required> <br>
											<label class="pt-2" for="select_owner">Owner</label>
											<select id="select-owner" name="owner" class="">
												<option selected value="none" class="d-none">No-one</option>
												<?php
												$user_dao = new user_dao(database_connection::get_instance()->get_resource());
												$results = $user_dao->get_all_users();
												if(!($results === false))
													foreach($results as $result) {
														$full_name = $result->get_name()." ".$result->get_surname();
														$id = $result->get_id();
														echo "<option value='$id'>$full_name</option>";
													}
												?>
											</select>
											<button class="mt-2 action-button px-5 py-2" type="submit">Add</button>
										</form>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<script src="js/sidebar.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.bundle.js"></script>
		<script
			src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
			integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
			crossorigin="anonymous"
			referrerpolicy="no-referrer"
		></script>
		<script src="js/select.js"></script>
</body>
</html>
