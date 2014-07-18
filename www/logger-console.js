function LoggerConsole (element, pollingUrl, frequency)
{
    this.element = element;
    this.pollingUrl = pollingUrl;
    this.frequency = frequency || 1000;
    this.streamFinished = false;
    this._tick();
}

LoggerConsole.prototype.log = function (string)
{
    var textElement = document.createElement('p');
    textElement.innerHTML = string;
    this.element.appendChild(textElement);
}

LoggerConsole.prototype._appendIncomingData = function (data)
{
    if (this.streamFinished)
    {
        return;
    }
    
    if (data.error !== undefined)
    {
        console.log('eeks an error');
        this.log(data.error);
        this.streamFinished = true;
        return;
    }
    
    if (data.complete === true)
    {
        this.log('Process finished.');
        this.streamFinished = true;
        return;
    }
    
    data.progress.forEach(this.log.bind(this));
}

LoggerConsole.prototype._tick = function ()
{
    $.getJSON(this.pollingUrl, this._appendIncomingData.bind(this));
    if (this.streamFinished === false)
    {
        setTimeout(this._tick.bind(this), this.frequency);
    }
}