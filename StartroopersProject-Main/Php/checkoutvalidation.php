<?php

                            $Fname = validate_input($_REQUEST['txt_fname']);
                            $Lname = validate_input($_REQUEST['txt_lname']);
                            $buyeremail = validate_input($_REQUEST['txt_email']);
                            $address1 = validate_input($_REQUEST['txt_address']);
                            $address2 = validate_input($_REQUEST['txt_address2']);
                            $zipcode = validate_input($_REQUEST['txt_zip']);

                            $city = validate_input($_REQUEST['txt_city']);
                            $state = validate_input($_REQUEST['txt_state']);
                            $buyerCno = validate_input($_REQUEST['txt_buyercno']);
                            $pmethod = validate_input($_REQUEST['payment']);
                            $date = date('Y-m-d H:i:s');
                            $status = "Payment comfirmed";
                            if (empty($_REQUEST['txt_fname']) || !isset($_REQUEST['txt_fname'])) {
                                $fnameerrormsg = "*Please fill in Firt name";
                            } else {
                                $Fname = $_REQUEST['txt_fname'];
                                $fnameerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_lname']) || !isset($_REQUEST['txt_lname'])) {
                                $lnameerrormsg = "*Please fill in Last name";
                            } else {
                                $Lname = $_REQUEST['txt_lname'];
                                $lnameerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_email']) || !isset($_REQUEST['txt_email'])) {
                                $emailerrormsg = "*Please fill in email";
                            } else {
                                $buyeremail = $_REQUEST['txt_email'];
                                $emailerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_address']) || !isset($_REQUEST['txt_address'])) {
                                $addresserrormsg = "*Please fill in address";
                            } else {
                                $TelNo = $_REQUEST['txt_address'];
                                $addresserrormsg = "";
                            }
                            if (empty($_REQUEST['txt_zip']) || !isset($_REQUEST['txt_zip'])) {
                                $ziperrormsg = "*Please fill in description";
                            } else {
                                $zipcode = $_REQUEST['txt_zip'];
                                $ziperrormsg = "";
                            }
                            if (empty($_REQUEST['txt_city']) || !isset($_REQUEST['txt_city'])) {
                                $cityerrormsg = "*Please fill in city";
                            } else {
                                $city = $_REQUEST['txt_city'];
                                $cityerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_state']) || !isset($_REQUEST['txt_state'])) {
                                $stateerrormsg = "*Please fill in state";
                            } else {
                                $state = $_REQUEST['txt_state'];
                                $stateerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_buyercno']) || !isset($_REQUEST['txt_buyercno'])) {
                                $cnoerrormsg = "*Please fill in contact number";
                            } else {
                                $state = $_REQUEST['txt_buyercno'];
                                $cnoerrormsg = "";
                            }