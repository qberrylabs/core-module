@push('AjaxScript')

<script  type="text/javascript">

    function deleteExchangeRate(id) {
        $.ajax({
            type : 'get',
                url: "/exchange-rates/destroy/"+id,
                cache: false,
                data: {
                id: id
                },
                success: function(result) {
                    $("body").prepend(result);
                //console.log("success");
                //$(".exchangeRates_"+id).hide(1000);

            },
                error: function(result) {
                console.log("error");
            }

        });
    }
</script>
@endpush
