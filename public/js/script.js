$(document).ready(function () {
    function asset(path=''){
        return $('body #asset').val()+path;
    }
   $('body').on('click', '.update',function () {
      var news = $(this);
      var id = news.parent('tr').attr('data-id');
      var title = news.parent('tr').children('.title').text();
      var description = news.parent('tr').children('.description').text();
      var news_link = news.parent('tr').attr('data-link');
      var image = news.parent('tr').attr('data-image_path');
      var form_news = $('.form-news');
      $("#title").val(title);
      $("#description").val(description);
      $("#link").val(news_link);
      $("#image").attr('src', asset('images/uploads/'+image));
      form_news  = form_news.attr('action')+'/'+id;
      $('.form-news').attr('action', form_news);
       $("#old_image_path").val(image);

   });

});