<!@extends('layouts.app',['class' => 'g-sidenav-show bg-gray-100'])

@include('layouts.navbars.auth.topnav', ['title' => 'Schools-Information'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Schools List</title>
     <style>

        table {
            margin-left:0px;
            border-collapse: collapse; 
            width: 100%;
            
        }
        
        th, td {
            border: 1px solid black; /
            padding: 10px; 
            text-align: 
        }
        
        th {
            background-color: coral; 
        }
    </style>
    
</head>
<body style="text-align:center;" >
    <h1>Schools</h1>

    <!-- Display success message if any -->
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo session('success'); ?>
        </div>
    <?php endif; ?>

    <!-- Add a link to create a new challenge -->
    <a href="<?php echo route('challenges.create'); ?>">School Information</a>

    <!-- Check if there are any challenges -->
    <?php if($school_representative->count() > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>School Name</th>
                    <th>School District</th>
                    <th>School RegNo</th>
                    <th>School phone</th>
                    <th>Representative Firstname</th>
                    <th>Representative Lastname</th>
                    <th>Representative Email</th>
                    <th>representative password</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($school_representative as $school): ?>
                    <tr>
                        <td><?php echo $school->school_name; ?></td>
                        <td><?php echo $school->school_district; ?></td>
                        <td><?php echo $school->school_regNo; ?></td>
                        <td><?php echo $school->school_phone; ?></td>
                        <td><?php echo $school->representative_firstname; ?></td>
                        <td><?php echo $school->representative_lastname;?></td>
                        <td><?php echo  $school->representative_email;?></td>
                        <td><?php echo $school->rep_password; ?></td>
                        
    
                        <td>
                            
                            <!-- Add a delete form here if needed -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No challenges found.</p>
    <?php endif; ?>

    
</body>
<footer style="background-color: #f0f0f0; padding: 10px; text-align:centre;">
    <p>&copy;Mathematics challenge Competition. Numbers Dont Lie</p>
</footer>
</html>

