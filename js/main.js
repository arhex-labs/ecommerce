function navBar(){
    var search = document.getElementById('nav');
    var bars = document.getElementById('bars');
    var main = document.getElementById('main');
    if(search.style.display == 'block'){
        search.style.display = 'none';
        bars.classList.add('fa-bars');
        bars.classList.remove('fa-times');
        main.style.width = "100%";
        main.style.position = "relative";
    } else {
        search.style.display = 'block';
        bars.classList.remove('fa-bars');
        bars.classList.add('fa-times');
        main.style.width = "calc(100% - 250px)";
        main.style.position = "absolute";
        main.style.right = "0";
    }
}

function collapse(id){
    var x = document.getElementById(id);
    if(x.style.display == 'none'){
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}

function fetch_data(query, page, id_name){
    if(query == ""){
        document.getElementById(id_name).innerHTML = "";
        return;
    } else {
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                document.getElementById(id_name).innerHTML = this.responseText;
            } else {
                document.getElementById(id_name).innerHTML = '<img src="loading.gif" />';
            }
        };
        var q = page + "?query=" + query;
        xml.open("GET", q, true);
        xml.send();
    }
}

function fetch_option(query, page, id_name){
    if(query == ""){
        document.getElementById(id_name).innerHTML = "<option value=''>Select Product</option>";
        return;
    } else {
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                document.getElementById(id_name).innerHTML = "<option value=''>Select Product</option>" + this.responseText;
            } else {
                document.getElementById(id_name).innerHTML = '<option value="">Loading...</option>';
            }
        };
        var q = page + "?query=" + query;
        xml.open("GET", q, true);
        xml.send();
    }
}

function fetch_orders(query, page, id_name){
    if(query == ""){
        document.getElementById(id_name).innerHTML = "";
        return;
    } else {
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                document.getElementById(id_name).innerHTML = this.responseText;
            } else {
                document.getElementById(id_name).innerHTML = '<img src="../img/loading.gif" />';
            }
        };
        var q = page + "?query=" + query;
        xml.open("GET", q, true);
        xml.send();
    }
}

function changeImage(img){
    var x = document.getElementById('main_image');
    x.style.backgroundImage = "url('"+img+"')";
}

function showFilter(){
    document.getElementById('filter').style.display = 'block';
}

function setQty(val){
    var x = document.getElementById('qty');
    var y = document.getElementById('pro_qty');
    if((parseInt(x.value) + parseInt(val)) > 0){
        x.value = parseInt(val) + parseInt(x.value);
        y.value = parseInt(val) + parseInt(x.value) - 1;
    }
}


function showDetails(){
    var x = document.getElementById('details');
    var y = document.getElementById('active');
    if(x.style.display == 'none'){
        x.style.display = 'block';
        y.innerHTML = "Hide Details";
    } else {
        x.style.display = 'none';
        y.innerHTML = "Show Details";
    }
}

function setSize(){
    var x = document.getElementById('size');
    var y = document.getElementById('psize');
    y.value = x.value;
}

function setColor(){
    var x = document.getElementById('color');
    var y = document.getElementById('pclr');
    y.value = x.value;
}
