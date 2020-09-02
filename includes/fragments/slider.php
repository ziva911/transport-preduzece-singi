<script src="./scripts/glider.js"></script>
       
          <div class="glider-contain">
            <button class="glider-prev" style="height: 100%; text-align:right;">&laquo;</button>
                  <div class="glider" style="width:740px;">
                    <div class="glider-slide active center visible" id="img1"style="height: auto; width:100%;">
                    <img src="./images/image1.jpg"/>
                    </div>
                    <div class="glider-slide right-1 hidden" style="height: auto; width:100%;">
                      <img src="./images/image2.jpg"/>
                    </div>
                    <div class="glider-slide right-2 hidden" style="height: auto; width:100%;">
                      <img src="./images/image3.jpg"/>
                    </div>
                    <div class="glider-slide right-3 hidden" style="height: auto; width:100%;">
                      <img src="./images/image4.jpg"/>
                    </div>
                    <div class="glider-slide right-4 hidden" style="height: auto; width:100%;">
                      <img src="./images/image5.jpg"/>
                    </div>
                  </div>
            <button class="glider-next"style="height: 100%; text-align:left;">&raquo;</button>
              
            <div id="dots" class=" glider-dots glider-dots glider-dots glider-dots glider-dots ">
              <button data-index="0" aria-label="Page 1" class="glider-dot active"></button>
              <button data-index="1" aria-label="Page 2" class="glider-dot"></button>
              <button data-index="2" aria-label="Page 3" class="glider-dot"></button>
              <button data-index="3" aria-label="Page 4" class="glider-dot"></button>
              <button data-index="4" aria-label="Page 5" class="glider-dot"></button>
            </div>
          </div>


          <script>
            new Glider(document.querySelector('.glider'), {
  slidesToShow: 1,
  dots: '#dots',
  draggable: true,
  arrows: {
    prev: '.glider-prev',
    next: '.glider-next'
  }
});
</script>
