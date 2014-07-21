/**
 * A class that polls a URL repeatedly at a desired frequency to log data on a job.
 * Any found data will then be appended inside an element to show the user progress.
 * 
 * @param {Element} element - The element to log to (append lines of data to)
 * @param {string} pollingUrl - The url to poll and expect JSON data in return from
 * @param {int} [frequency] - The frequency in milliseconds to poll the URL; defaults to 1000 if not specified
 * @constructor
 */
function LoggerConsole (element, pollingUrl, frequency)
{
    this.element = element;
    this.pollingUrl = pollingUrl;
    this.frequency = frequency || 1000;
    
    // prevent infinity loop; if this is set to false, all handling of data logging and polling will be stopped
    this.streamFinished = false;
    
    // start the loop
    this._tick();
}

/**
 * Log a line of information to the LoggerConsole's Element.
 * 
 * @param {string} line - The line to log (the line to append as an HTMLParagraphElement and child to the LoggerConsole's Element) 
 */
LoggerConsole.prototype.log = function (line)
{
    // create an HTMLParagraphElement with the line to log to append as a child
    var textElement = document.createElement('p');
    textElement.innerHTML = line;
    this.element.appendChild(textElement);
}

/**
 * Handle incoming data, in particular log relevant data to the console, whether it be an error or the data required. (private)
 * 
 * @param {Object} data - The data to handle in the form of a JSON object in the format of what is expected from the server
 * @param {string} [data.error] - If present, an error has occured server-side, and it is described here in string form
 * @param {boolean} [data.complete] - A true/false value describing whether activity on the server has ceased or not (and hence if logging can also stop)
 * @param {string[]} [data.progress] - An array of Strings to be logged as lines
 */
LoggerConsole.prototype._handleDataLogging = function (data)
{
    // if we're playing catch up, there may be a response even after we've stopped creating requests; if so, ignore data
    if (this.streamFinished)
    {
        return;
    }
    
    // if an error is present...
    if (data.error !== undefined)
    {
        // ...moan about it and stop
        this.log(data.error);
        this.streamFinished = true;
        return;
    }
    
    // if all work server-side is done...
    if (data.complete === true)
    {
        // let the user know and stop bothering the server
        this.log('Process finished.');
        this.streamFinished = true;
        return;
    }
    
    // log all received lines to the console
    data.progress.forEach(this.log.bind(this));
}

/**
 * The tick loop that repeatedly polls the server and stops if this.streamFinished indicates that it should have. (private)
 */
LoggerConsole.prototype._tick = function ()
{
    // request JSON from the server
    $.getJSON(this.pollingUrl, this._appendIncomingData.bind(this));
    
    // if we're not done, schedule the next tick
    if (!this.streamFinished)
    {
        setTimeout(this._tick.bind(this), this.frequency);
    }
}