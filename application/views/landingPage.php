<?php defined('BASEPATH') OR exit('direct access not allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Leave Requests</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
            #select-placeholder{
                display: none;
            }
            label,select,input{
                margin-left: 1rem;
                padding: .5rem;
            }
            input[type="submit"],a{
                box-shadow: 2px 2px 1px 1px black;
            }
            a{
                text-decoration: none;
                color: black;
                text-align: center;
                border: 1px solid black;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){

                /* get the href dynamically */
                $.get('/requests/get_new_anchor',function(res){
                        $('a').attr('href', res);
                })

                /* initialize fetch tbody */
                $.get('/requests/fetch_all',function(res){
                    $('tbody').html(res);
                    update_counter();
                })
                
                /* get the tbody dynamically */
                $('form').on('change',function(){
                    console.log('submitting form');
                    $.post($(this).attr('action'),$(this).serialize(),function(res){
                        $('tbody').html(res);
                        update_counter();
                    });
                    return false;
                })

                /* update the tbody and href dynamically */
                $('a').on('click',function(event){
                    $.get($(this).attr('href'),function(res){
                        $('tbody').html(res);
                        update_counter();
                            $.get('/requests/get_new_anchor',function(res){
                                $('a').attr('href', res);
                            })
                    })
                    event.preventDefault();
                })
            })
            function update_counter(){
                $.get('/requests/get_result_count',function(res){
                    $('span').html(res);
                })
            }
        </script>
    </head>
    <body>
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center">
                <h1><span></span> Leave Request</h1>
                <form action="/requests/filter_request" method="POST">
                    <label>
                        <input type="radio" value="recent" name="filter-time">
                        Most Recent
                    </label>
                    <label>
                        <input type="radio" value="old" name="filter-time">
                        Older requests
                    </label>
                    <select name="leave-type">
                        <option value="all" selected id="select-placeholder">Leave Type</option>
                        <option value="vacation">Vacation</option>
                        <option value="sick">Sick Leave</option>
                        <option value="unpaid">Unpaid Leave</option>
                        <option value="paid">Paid Leave</option>
                        <option value="half-day">Half Day Unpaid</option>
                    </select>
                    <input type="submit" value="Search">
                </form>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee Name</th>
                        <th>Request Date</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Leave Type</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="row">
                <a href="/requests/show_more/10" class="col-12 m-auto">Show More</a>
            </div>
        </div>
    </body>
</html>