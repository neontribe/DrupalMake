{extends file="page.tpl"}
{block name=body}
            <h2>Save File</h2>
            {if $response == "File Overwritten" || $response == "File Saved"}<h3>Saved as: {$name}.{$type}</h3>{/if}
            <h3>{$response}</h3><br />
            <textarea rows="20" cols="122" style="white-space:nowrap;overflow:auto;">{$file}</textarea>
            {if $type == "manifest"}
            <form method="GET" action="build.php">
                <input type="hidden" name="name" value="{$path}" />
                <button class="right">Build (May take a few minutes) &rArr;</button>
            </form>
            <button onclick="goBack()">&lArr; Go back</button>
            {else}
            <button onclick="goBack()">&lArr; Go back and create Manifest</button>
            {/if}
{/block}