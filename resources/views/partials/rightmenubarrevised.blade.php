<style>
    #wrapper {
        padding-left: 0;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    #sidebar-wrapper {
        z-index: 1000;
        position: fixed;
        right: 250px;
        width: 0;
        height: 100%;
        margin-right: -250px;
        overflow-y: auto;
        background: #212529;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
        padding-top: 4%;
    }

    #wrapper {
        padding-right: 250px;
    }

    #sidebar-wrapper {
        width: 250px;
    }

    /* .nav-link {
        color: white;
    } */
</style>

<div id="wrapper">
    <div id="sidebar-wrapper">
        <nav class="sb-sidenav-menu-nested nav" id="sidebarright">
            </nav>
    </div>
</div>
<script>
    const data_ar = <?php echo json_encode($data_ar); ?>;
    // alert(JSON.stringify(data_ar));
    for (var i = 0; i < data_ar.length; i++) {
        var mydiv = document.getElementById("sidebarright");
        var aTag = document.createElement('button');
        // aTag.setAttribute('href', "");
        aTag.setAttribute('onclick', 'myFunction1(' +i+ ')');
        aTag.setAttribute('class', 'nav-link');
        aTag.innerText = data_ar[i].type_of_hunt + '-' + data_ar[i].customer_name + '-' + data_ar[i].cat_sales_stage +
            '-' + data_ar[i].guide_name;
        mydiv.appendChild(aTag);
    }

    function myFunction1(i){
        console.log(i);
        var table = document.getElementById("detailTable");
    }
</script>
