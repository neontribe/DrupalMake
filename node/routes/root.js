function registerMiddleware (app)
{
	app.get('/', handleRoot);
}

module.exports = exports = registerMiddleware;

var PUBLIC_ROOT = __dirname + '/../public';

function handleRoot (request, response)
{
	response.sendfile('index.html', { root: PUBLIC_ROOT });
}