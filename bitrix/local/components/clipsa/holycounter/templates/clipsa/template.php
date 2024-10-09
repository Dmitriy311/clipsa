<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
CJSCore::Init(array('ajax'));
$this->addExternalCss("/local/components/clipsa/holycounter/templates/clipsa/styles.css");
?>

    <form id="counter" action="" method="POST">

        <div class="form-group">
            <label for="increment">Add number of business days...</label>
            <input type="text" id="increment" name="increment" value="">
        </div>
        <div class="form-group">
            <label for="increment">...after this date: </label>
            <input type="text" id="start_date" name="start_date" value="">
        </div>

        <input type="submit" name="submit" value="Submit"">

    </form>

<div class="result" id="result"></div>


<script>

    const form = document.getElementById('counter');
    form.addEventListener("submit", submitForm, false);

    function submitForm(event) {
        event.preventDefault();

        let url = form.getAttribute('action'),
            start = document.getElementById('start_date').value;
            inc = document.getElementById('increment').value;

        BX.ajax.runComponentAction('clipsa:holycounter', 'HolyCounter', {
            mode: 'class',
            data: {
                start_date: start,
                increment: inc
            },
            analyticsLabel: {
                viewMode: 'grid',
                filterState: 'closed'
            }
        }).then(function (response) {
            document.getElementById('result').innerText = 'Calculated business day will be: ' + response.data;
        }, function (response) {
            console.log(response);
            alert('An error occured. Check console output for more details.');
        });
    }

</script>