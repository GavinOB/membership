<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

<?php if (isset($home_page) && $home_page !== TRUE):?>
		 <?php
foreach($css_files as $file): ?>
<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<?php endif;?>

<style type='text/css'>
body
{
    font-family: Arial;
    font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
    text-decoration: underline;
}
/*
#menu table {
    table-layout: fixed;
    width: 400px;
}

#menu th, td {
    overflow: hidden;
    width: 150px;
}
*/
</style>
</head>
<body>
<!-- Beginning header -->
<h1>Roosevelt Boston Member Tracking</h1>
    <div class="menu">
    	<table>
    	<tr>
    	<td>Data Entry:</td>
        <td>
        <a href='<?php echo site_url('main/attendees')?>'>Attendees</a> |
        <a href='<?php echo site_url('main/events')?>'>Events</a> |
        <a href='<?php echo site_url('main/organizations')?>'>Organizations</a> |
        <a href='<?php echo site_url('main/memberstatus')?>'>Status Codes</a>
        </td>
        </tr>
<!--
        <tr>
        <td>Summary Views:</td>
        <td><a href='<?php echo site_url('main/eventcounts')?>'>Events Attended</td>
        </tr>
-->
        </table>
    </div>
<!-- End of header-->
    <div style='height:20px;'></div>
    <div>
    <?php if (isset($home_page) && $home_page !== TRUE):?>
    <?php echo $output; ?>
    <?php endif;?>

    </div>
<!-- Beginning footer -->
<div></div>
<!-- End of Footer -->
</body>
</html>
