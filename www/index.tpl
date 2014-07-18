{extends file="page.tpl"}
{block name=body}
            <div style="float:left">
                <u><h2>Modify Existing Make File</h2></u><br />
                Choose Existing Make File:<br />
                <form action="read.php" method="post">
                    <select name="file">
                    {foreach from=$makefiles item=filename}
                       {html_options values={$filename} output={$filename}}   
                    {/foreach}
                    </select>
                    <button>Modify the selected file &rArr;</button>
                </form>
                <br /><br />
            </div>
            <div style="float:right">
                <u><h2>Create New Make File</h2></u>
                <button onclick="location.href='repos.php'">Create a New Make File &rArr;</button>
            </div>
{/block}