<!DOCTYPE html>
<html>

<head>
</head>

<body style="font-family: 'Lato', Arial, sans-serif;">

    <?php $date = date('Y-m-d', strtotime("-1 days")); ?>

    <table style="width: 630px;text-align: center;margin: 0 auto;background:#f2f2f2;border:1px solid #e6e6e6;">
        <tr>
            <td style="width: 30px;"></td>
            <td style="width: 560px;">

                <table style="width: 560px;text-align: center;margin: 0 auto;">
                    <thead>
                        <tr style="height: 60px;">
                            <td></td>
                        </tr>

                        <tr>
                            <td style="width:170px;height:66px;">
                                <a href="https://www.willshall.com/"><img src="{{ asset('custom/images/logo.png') }}"></a>
                            </td>
                        </tr>

                        <tr style="height: 48px;">
                            <td></td>
                        </tr>
                        <tr>
                            <td class="text-center" style="font-size:25px; font-family: 'Lato', Arial, sans-serif;text-transform: uppercase;font-weight:normal;">List Of Inactive Project Since Last 30 Days</td>
                        </tr>

                        <tr style="height: 37px;">
                            <td></td>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid #dad1d1;background:#fff;">
                                <table style="width: 100%;">
                                    <tbody>

                                        <tr>
                                            <td style="width: 34px;"></td>
                                            <td style="text-align:left;font-size:16px;font-weight: 600;">
                                                <p style="margin:30px 0 5px;">Hi Admin,</p>
                                                <p style="margin:30px 0 5px;">These're the Projects in which no activity filled in dsr has been done for the last 30 days:</p>

                                                <ul>
                                                    @foreach($name as $list_project) 
                                                     <?php 
                                                       $obj = json_decode($list_project); 
                                                       $project_id = $obj[0]->id;
                                                     ?>   
                                                         <li style="font-weight:normal;">
                                                             <a href="{{route('view-project', $project_id)}}" target = "_blank">
                                                                  <?php echo $obj[0]->project_title;  ?>
                                                             </a>
                                                         </li>                                               
                                                     <br/>
                                                    @endforeach
                                                </ul> 

                                            </td>
                                            <td style="width: 34px;"></td>
                                        </tr>

                                        <tr>
                                            <td style="width: 34px;"></td>
                                            <td style="text-align: left;font-size:15px;line-height: 22px;">
                                                <p style="margin:0px 0 25px;">Thanks,
                                                    <br>Willshall PMS</p>
                                            </td>
                                            <td style="width: 34px;"></td>
                                        </tr>

                                    </tbody>
                                </table>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size: 12px;color:#8c8989;margin: 50px 0;">Copyright @ 2020 Willshall Consulting.
                                    <br>All Right Reserved. <a href="https://www.willshall.com/privacy-policy.htm" style="text-decoration: underline;color:#8c8989;">Privacy policy</a></p>
                            </td>
                        </tr>

                    </tbody>

                </table>

            </td>
            <td style="width: 30px;"></td>
        </tr>
      </table>

</body>
</html>