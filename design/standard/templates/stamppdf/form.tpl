{if $errors}
    <h3>Errors</h3>
    <ul>
        {foreach $errors as $error}
            <li>{$error}</li>
        {/foreach}
    </ul>
{/if}
<form action="{'/stamppdf/test'|ezurl(no)}" method='post'>
    <label for="pdf_string">PDF Stamp Text</label>
    <input name="pdf_string" id="pdf_string" type="text">
    <input type="submit" value="Download PDF">
</form>
