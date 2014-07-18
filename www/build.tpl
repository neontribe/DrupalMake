{extends file="page.tpl"}
{block name=body}
            <h2 id="status">Building Site...</h2>
            <pre id="progress-log" style="white-space:nowrap;overflow:auto;"></pre>
            <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
            <script src="logger-console.js"></script>
            <script>
                var loggerConsole = new LoggerConsole(document.getElementById('progress-log'), 'progress.php?id={$hash}');
                
                var status = document.getElementById('status');
                var logo = document.getElementById('logo');
                var logoRotation = 0;
                
                function tick ()
                {
                    if (loggerConsole.streamFinished)
                    {
                        document.getElementById('status').innerHTML = "Built. (there may be errors)";
                        logo.style.webkitTransform = 'none';
                    }
                    else
                    {
                        requestAnimationFrame(this.tick, 1000);
                        logoRotation += 10;
                        logoRotation %= 360;
                        logo.style.webkitTransform = 'rotate(' + Math.round(logoRotation) + 'deg)';
                    }
                }
                
                tick();
            </script>
{/block}