<!DOCTYPE html>
<html class="loading semi-dark-layout" lang="en" data-layout="semi-dark-layout" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Jewellery Dukan - Invoice</title>
    <link rel="apple-touch-icon" href="{{ asset('public/admin/app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/app-assets/vendors/css/vendors.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/app-assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/app-assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/app-assets/css/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/app-assets/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/app-assets/css/pages/app-invoice-print.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/style.css')}}">
    <!-- END: Custom CSS-->

    <style>
        .table:not(.table-dark):not(.table-light) thead:not(.table-dark) th, .table:not(.table-dark):not(.table-light) tfoot:not(.table-dark) th {
    background-color: white !important;
    color: #fcfdfe;
}

body {
    margin: 0;
    padding: 0;
    /* height: 100vh; */
    /* display: flex; */
    /* justify-content: center; */
    /* align-items: center; */
}

.fixed-width {
    width: 100px; /* Adjust this width as needed */
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
}

table.datatables-ajax.table.table-responsive .py-1 {
    max-width: 33% !important;
    width: 0%;
}

.centered-table {
    text-align: center;
}
    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content  " id="overall_PDF">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="invoice-print p-3">
                    <div class="invoice-header d-flex justify-content-between flex-md-row flex-column pb-2">
                        
                    </div>

                    <div style="background: black;color: white !important;letter-spacing: 12px;    text-align: center;    font-size: 22px;font-weight: 600;">
                        SALES ORDER RECEIPT
                    </div>

                    <div class="row" style="padding-top: 2%;">
                        <div class="col-md-12">
                            

                            <div class="centered-table">
                                <table class="datatables-ajax table table-responsive">
                                    <tr>
                                        <th class="py-1">GSTIN: 08ACPOK8594I9Z0</th>
                                        <th class="py-1" rowspan="2" >MEDICO AGENCIES <br>
                                            22,Shopping Center,J.L.N. Hospital Road,Ajmer -305001
                                            </th>
                                        <th class="py-1" >Phone: 0145-2877655</th>
                                    </tr>
                                    <tr>
                                        <th class="py-1" >DL No: 1234-1235</th>
                                        <th class="py-1">Mobile: {{ $user->mobile }}</th>
                                    </tr>
                                </table>
                            </div>

                            <div class="centered-table">
                                <table class="datatables-ajax table table-responsive">
                                    <tr>
                                        <th class="py-1">{{ $user->business_name }}</th>
                                        
                                        <th class="py-1" rowspan="2" >DL No.: {{ $user->dl }}</th>
                                        <th class="py-1" rowspan="2" >Entry No : {{ $order->id }} <br>
                                            Date : {{ date('d-m-y H:i:s',strtotime($order->created_at)) }}
                                            </th>
                                    </tr>
                                    <tr>
                                        <th class="py-1" >State Code: 08</th>
                                        {{-- <th class="py-1">Mobile: 9876567890</th> --}}
                                    </tr>
                                    
                                </table>
                            </div>

                            <div class="centered-table">
                                <table class="datatables-ajax table table-responsive">
                                    <tr>
                                        <th class="py-1">Sr no</th>
                                        <th class="py-1">Product Name</th>
                                        <th class="py-1">Qty</th>
                                    </tr>
                                    <?php $i=1; ?>
                                    @foreach ($order_item as $item)
                                        <tr>
                                            <td class="py-1">{{ $i }}</td>
                                            <td class="py-1">{{ $item->product_name }}</td>
                                            <td class="py-1">{{ $item->quantity }}</td>
                                        </tr>
                                        <?php $i++; ?>
                                    @endforeach
                                    
                                    
                                </table>
                            </div>


                        </div>
                    </div>

                    
                </div>


                

            </div>

            
        </div>
    </div>

                        
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('public/admin/app-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('public/admin/app-assets/js/core/app-menu.js')}}"></script>
    <script src="{{ asset('public/admin/app-assets/js/core/app.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    {{-- <script src="{{ asset('public/admin/app-assets/js/scripts/pages/app-invoice-print.js')}}"></script> --}}
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>


    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    
    {{-- <script>
         //Download as PDF
    window.onload = function () {

    document.getElementById("pdf_download")
        .addEventListener("click", () => {
            const overall_PDF = this.document.getElementById("overall_PDF");
         const pdf = "Kapil.pdf";
            console.log(overall_PDF);
            console.log(window*2);
            
            var opt = {

                margin: 0.2,
                filename: pdf,
                image: { type: 'png', quality: 0.98 },
                // html2canvas: {scrollX: 0,  scrollY: 0, dpi: 600, letterRendering: true, },
                jsPDF: { unit: 'in', format: 'A4', orientation: 'p' }
            };
            html2pdf().from(overall_PDF).set(opt).save();
        })
} 

 
    </script> --}}


</body>
<!-- END: Body-->


</html>