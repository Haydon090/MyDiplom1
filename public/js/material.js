jQuery(document).ready(function($) {
    $('#contactForm').on('submit', function(event) {
        event.preventDefault();

        let Content = $('#Content').val();
        let LessionId = $('#lessionId').val(); // Получаем значение из скрытого поля
        alert(LessionId);
        let Type = "Text";

        $.ajax({
            url: "/materials",// Обновляем URL, включая параметр LessionId
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "Content": Content,
                "lessionId": LessionId,
                "Type": Type
            },
            success: function(response) {
                console.log(response);
            },
        });
    });
});
