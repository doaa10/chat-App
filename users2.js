const searchBar=document.querySelector(".users .search input");
const searchBtn=document.querySelector(".users .search button");
const usersList=document.querySelector(".users .users-list");


searchBtn.onclick = ()=>{
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");

}

searchBar.onkeyup=()=>{
    let searchTerm=searchBar.value;

    let xhr=new XMLHttpRequest();
    xhr.open("POST","search.php",true);
    xhr.onload=()=>{
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data=xhr.response;
                usersList.innerHTML=data;
            }
        }


    }
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("searchTerm=" +searchTerm);
}