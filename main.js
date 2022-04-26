document.addEventListener('DOMContentLoaded',()=>{
    function setFocused() {
        var searchBox = document.querySelector('.search-box');
        searchBox.style.backgroundColor = "#ffffff"
      }
      
      function unsetFocused() {
        var searchBox = document.querySelector('.search-box');
        searchBox.style.backgroundColor = "#dddddd";
      }

           
      var result = document.querySelector('#search-box-input');
        result.addEventListener("focusin", setFocused);
        result.addEventListener("focusout", unsetFocused);
       
});

var comment_show = querySelectorAll(`[id^="#commentArea"]`);

comment_show.addEventListener(click,()=>{
      array.forEach(element => {
        
      });

})

