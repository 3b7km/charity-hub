<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.9.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.9.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-donors-export">
                                <a href="#endpoints-GETapi-donors-export">Export all personal data for the authenticated donor.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-donations">
                                <a href="#endpoints-POSTapi-donations">POST /api/donations
Initiate a one-time donation. Returns client_secret for Stripe.js confirmation.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-donations--id-">
                                <a href="#endpoints-GETapi-donations--id-">GET /api/donations/{id}
Get donation status for the authenticated donor.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-campaigns">
                                <a href="#endpoints-GETapi-campaigns">GET /campaigns
Public listing of active campaigns.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-volunteers-register">
                                <a href="#endpoints-POSTapi-volunteers-register">POST api/volunteers/register</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-volunteers-schedules">
                                <a href="#endpoints-GETapi-volunteers-schedules">GET api/volunteers/schedules</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: April 29, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-donors-export">Export all personal data for the authenticated donor.</h2>

<p>
</p>



<span id="example-requests-GETapi-donors-export">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/donors/export" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/donors/export"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-donors-export">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Server Error&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-donors-export" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-donors-export"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-donors-export"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-donors-export" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-donors-export">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-donors-export" data-method="GET"
      data-path="api/donors/export"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-donors-export', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-donors-export"
                    onclick="tryItOut('GETapi-donors-export');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-donors-export"
                    onclick="cancelTryOut('GETapi-donors-export');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-donors-export"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/donors/export</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-donors-export"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-donors-export"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-donations">POST /api/donations
Initiate a one-time donation. Returns client_secret for Stripe.js confirmation.</h2>

<p>
</p>



<span id="example-requests-POSTapi-donations">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/donations" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"campaign_id\": \"66529e01-d113-3473-8d6f-9e11e09332ea\",
    \"amount\": 96,
    \"currency\": \"eop\",
    \"idempotency_key\": \"c2cdda66-81e5-3060-a4eb-049b4a810d76\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/donations"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "campaign_id": "66529e01-d113-3473-8d6f-9e11e09332ea",
    "amount": 96,
    "currency": "eop",
    "idempotency_key": "c2cdda66-81e5-3060-a4eb-049b4a810d76"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-donations">
</span>
<span id="execution-results-POSTapi-donations" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-donations"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-donations"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-donations" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-donations">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-donations" data-method="POST"
      data-path="api/donations"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-donations', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-donations"
                    onclick="tryItOut('POSTapi-donations');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-donations"
                    onclick="cancelTryOut('POSTapi-donations');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-donations"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/donations</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-donations"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-donations"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>campaign_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="campaign_id"                data-endpoint="POSTapi-donations"
               value="66529e01-d113-3473-8d6f-9e11e09332ea"
               data-component="body">
    <br>
<p>Must be a valid UUID. The <code>id</code> of an existing record in the campaigns table. Example: <code>66529e01-d113-3473-8d6f-9e11e09332ea</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount"                data-endpoint="POSTapi-donations"
               value="96"
               data-component="body">
    <br>
<p>Must be at least 100. Example: <code>96</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>currency</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="currency"                data-endpoint="POSTapi-donations"
               value="eop"
               data-component="body">
    <br>
<p>Must be 3 characters. Example: <code>eop</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>idempotency_key</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="idempotency_key"                data-endpoint="POSTapi-donations"
               value="c2cdda66-81e5-3060-a4eb-049b4a810d76"
               data-component="body">
    <br>
<p>Must be a valid UUID. Example: <code>c2cdda66-81e5-3060-a4eb-049b4a810d76</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-donations--id-">GET /api/donations/{id}
Get donation status for the authenticated donor.</h2>

<p>
</p>



<span id="example-requests-GETapi-donations--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/donations/consequatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/donations/consequatur"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-donations--id-">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Server Error&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-donations--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-donations--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-donations--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-donations--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-donations--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-donations--id-" data-method="GET"
      data-path="api/donations/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-donations--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-donations--id-"
                    onclick="tryItOut('GETapi-donations--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-donations--id-"
                    onclick="cancelTryOut('GETapi-donations--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-donations--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/donations/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-donations--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-donations--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-donations--id-"
               value="consequatur"
               data-component="url">
    <br>
<p>The ID of the donation. Example: <code>consequatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-campaigns">GET /campaigns
Public listing of active campaigns.</h2>

<p>
</p>



<span id="example-requests-GETapi-campaigns">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/campaigns" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/campaigns"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-campaigns">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">content-type: text/html; charset=utf-8
cache-control: no-cache, private
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1.0&quot;&gt;
    &lt;title&gt;Campaigns &mdash; CharityHub&lt;/title&gt;

    
    &lt;meta name=&quot;description&quot; content=&quot;Browse active fundraising campaigns and make a difference today.&quot;&gt;
        &lt;meta property=&quot;og:title&quot; content=&quot;Campaigns &mdash; CharityHub&quot;&gt;
    &lt;meta property=&quot;og:description&quot; content=&quot;Browse active fundraising campaigns and make a difference today.&quot;&gt;
    &lt;meta property=&quot;og:type&quot; content=&quot;website&quot;&gt;
    &lt;meta name=&quot;twitter:card&quot; content=&quot;summary_large_image&quot;&gt;

    
    &lt;link rel=&quot;preconnect&quot; href=&quot;https://fonts.googleapis.com&quot;&gt;
    &lt;link rel=&quot;preconnect&quot; href=&quot;https://fonts.gstatic.com&quot; crossorigin&gt;
    &lt;link href=&quot;https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap&quot; rel=&quot;stylesheet&quot;&gt;

    
    &lt;!-- Livewire Styles --&gt;&lt;style &gt;[wire\:loading][wire\:loading], [wire\:loading\.delay][wire\:loading\.delay], [wire\:loading\.list-item][wire\:loading\.list-item], [wire\:loading\.inline-block][wire\:loading\.inline-block], [wire\:loading\.inline][wire\:loading\.inline], [wire\:loading\.block][wire\:loading\.block], [wire\:loading\.flex][wire\:loading\.flex], [wire\:loading\.table][wire\:loading\.table], [wire\:loading\.grid][wire\:loading\.grid], [wire\:loading\.inline-flex][wire\:loading\.inline-flex] {display: none;}[wire\:loading\.delay\.none][wire\:loading\.delay\.none], [wire\:loading\.delay\.shortest][wire\:loading\.delay\.shortest], [wire\:loading\.delay\.shorter][wire\:loading\.delay\.shorter], [wire\:loading\.delay\.short][wire\:loading\.delay\.short], [wire\:loading\.delay\.default][wire\:loading\.delay\.default], [wire\:loading\.delay\.long][wire\:loading\.delay\.long], [wire\:loading\.delay\.longer][wire\:loading\.delay\.longer], [wire\:loading\.delay\.longest][wire\:loading\.delay\.longest] {display: none;}[wire\:offline][wire\:offline] {display: none;}[wire\:dirty]:not(textarea):not(input):not(select) {display: none;}:root {--livewire-progress-bar-color: #2299dd;}[x-cloak] {display: none !important;}[wire\:cloak] {display: none !important;}dialog#livewire-error::backdrop {background-color: rgba(0, 0, 0, .6);}&lt;/style&gt;

    
    &lt;link rel=&quot;stylesheet&quot; href=&quot;http://localhost/css/app.css&quot;&gt;
    &lt;/head&gt;
&lt;body&gt;
    
    &lt;nav class=&quot;navbar&quot; id=&quot;main-nav&quot;&gt;
        &lt;div class=&quot;nav-container&quot;&gt;
            &lt;a href=&quot;http://localhost&quot; class=&quot;nav-logo&quot;&gt;
                &lt;span class=&quot;nav-logo-icon&quot;&gt;&hearts;&lt;/span&gt;
                &lt;span class=&quot;nav-logo-text&quot;&gt;CharityHub&lt;/span&gt;
            &lt;/a&gt;
            &lt;div class=&quot;nav-links&quot;&gt;
                &lt;a href=&quot;http://localhost/campaigns&quot; class=&quot;nav-link&quot;&gt;Campaigns&lt;/a&gt;
                &lt;a href=&quot;#&quot; class=&quot;nav-link&quot;&gt;Volunteer&lt;/a&gt;
                &lt;a href=&quot;#&quot; class=&quot;nav-link&quot;&gt;Impact&lt;/a&gt;
                                    &lt;a href=&quot;/admin/login&quot; class=&quot;nav-link nav-cta&quot;&gt;Sign In&lt;/a&gt;
                            &lt;/div&gt;
            &lt;button class=&quot;nav-mobile-toggle&quot; id=&quot;mobile-menu-btn&quot; aria-label=&quot;Toggle menu&quot;&gt;
                &lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;&lt;span&gt;&lt;/span&gt;
            &lt;/button&gt;
        &lt;/div&gt;
    &lt;/nav&gt;

    
    &lt;main&gt;
        &lt;section class=&quot;campaigns-hero&quot;&gt;
    &lt;div class=&quot;hero-overlay&quot;&gt;&lt;/div&gt;
    &lt;div class=&quot;hero-content&quot;&gt;
        &lt;h1 class=&quot;hero-title&quot;&gt;Active Campaigns&lt;/h1&gt;
        &lt;p class=&quot;hero-subtitle&quot;&gt;Every donation counts. Find a cause you believe in and make your impact today.&lt;/p&gt;
    &lt;/div&gt;
&lt;/section&gt;

&lt;section class=&quot;campaigns-grid-section&quot;&gt;
    &lt;div class=&quot;campaigns-container&quot;&gt;
                    &lt;article class=&quot;campaign-card&quot; id=&quot;campaign-019ddb58-79de-7013-9afe-6e9be7fe9a05&quot;&gt;
                &lt;div class=&quot;card-image&quot;&gt;
                                            &lt;div class=&quot;card-image-placeholder&quot;&gt;
                            &lt;span&gt;&hearts;&lt;/span&gt;
                        &lt;/div&gt;
                                        &lt;div class=&quot;card-badge card-badge-active&quot;&gt;
                        Active
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;card-body&quot;&gt;
                    &lt;h2 class=&quot;card-title&quot;&gt;
                        &lt;a href=&quot;http://localhost/campaigns/clean-water-initiative&quot;&gt;Clean Water Initiative&lt;/a&gt;
                    &lt;/h2&gt;
                    &lt;p class=&quot;card-desc&quot;&gt;Help us provide clean, accessible drinking water to remote villages. Every drop counts in our mission to eradicate water...&lt;/p&gt;

                    &lt;div class=&quot;card-progress&quot;&gt;
                        &lt;div class=&quot;card-progress-bar&quot;&gt;
                            &lt;div class=&quot;card-progress-fill&quot; style=&quot;width: 25%&quot;&gt;&lt;/div&gt;
                        &lt;/div&gt;
                        &lt;div class=&quot;card-progress-info&quot;&gt;
                            &lt;span class=&quot;card-raised&quot;&gt;&pound;12,500.00&lt;/span&gt;
                            &lt;span class=&quot;card-goal&quot;&gt;of &pound;50,000.00&lt;/span&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;

                    &lt;div class=&quot;card-footer&quot;&gt;
                        &lt;span class=&quot;card-donors&quot;&gt;0 donors&lt;/span&gt;
                        &lt;span class=&quot;card-days&quot;&gt;
                                                            -19.050309715764 days left
                                                    &lt;/span&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/article&gt;
                    &lt;article class=&quot;campaign-card&quot; id=&quot;campaign-019ddb58-79e4-7303-828d-0246496e86dc&quot;&gt;
                &lt;div class=&quot;card-image&quot;&gt;
                                            &lt;div class=&quot;card-image-placeholder&quot;&gt;
                            &lt;span&gt;&hearts;&lt;/span&gt;
                        &lt;/div&gt;
                                        &lt;div class=&quot;card-badge card-badge-active&quot;&gt;
                        Active
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;card-body&quot;&gt;
                    &lt;h2 class=&quot;card-title&quot;&gt;
                        &lt;a href=&quot;http://localhost/campaigns/education-for-all&quot;&gt;Education for All&lt;/a&gt;
                    &lt;/h2&gt;
                    &lt;p class=&quot;card-desc&quot;&gt;Empowering the next generation through education. We are raising funds to build a new school and provide essential learn...&lt;/p&gt;

                    &lt;div class=&quot;card-progress&quot;&gt;
                        &lt;div class=&quot;card-progress-bar&quot;&gt;
                            &lt;div class=&quot;card-progress-fill&quot; style=&quot;width: 80%&quot;&gt;&lt;/div&gt;
                        &lt;/div&gt;
                        &lt;div class=&quot;card-progress-info&quot;&gt;
                            &lt;span class=&quot;card-raised&quot;&gt;&pound;20,000.00&lt;/span&gt;
                            &lt;span class=&quot;card-goal&quot;&gt;of &pound;25,000.00&lt;/span&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;

                    &lt;div class=&quot;card-footer&quot;&gt;
                        &lt;span class=&quot;card-donors&quot;&gt;0 donors&lt;/span&gt;
                        &lt;span class=&quot;card-days&quot;&gt;
                                                            -4.0503097121528 days left
                                                    &lt;/span&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/article&gt;
                    &lt;article class=&quot;campaign-card&quot; id=&quot;campaign-019ddb58-79e7-7254-99fc-1abf6bc2004a&quot;&gt;
                &lt;div class=&quot;card-image&quot;&gt;
                                            &lt;div class=&quot;card-image-placeholder&quot;&gt;
                            &lt;span&gt;&hearts;&lt;/span&gt;
                        &lt;/div&gt;
                                        &lt;div class=&quot;card-badge card-badge-active&quot;&gt;
                        Active
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;card-body&quot;&gt;
                    &lt;h2 class=&quot;card-title&quot;&gt;
                        &lt;a href=&quot;http://localhost/campaigns/emergency-disaster-relief&quot;&gt;Emergency Disaster Relief&lt;/a&gt;
                    &lt;/h2&gt;
                    &lt;p class=&quot;card-desc&quot;&gt;Immediate assistance required for communities affected by the recent natural disaster. Funds will go directly towards fo...&lt;/p&gt;

                    &lt;div class=&quot;card-progress&quot;&gt;
                        &lt;div class=&quot;card-progress-bar&quot;&gt;
                            &lt;div class=&quot;card-progress-fill&quot; style=&quot;width: 0%&quot;&gt;&lt;/div&gt;
                        &lt;/div&gt;
                        &lt;div class=&quot;card-progress-info&quot;&gt;
                            &lt;span class=&quot;card-raised&quot;&gt;&pound;0.00&lt;/span&gt;
                            &lt;span class=&quot;card-goal&quot;&gt;of &pound;100,000.00&lt;/span&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;

                    &lt;div class=&quot;card-footer&quot;&gt;
                        &lt;span class=&quot;card-donors&quot;&gt;0 donors&lt;/span&gt;
                        &lt;span class=&quot;card-days&quot;&gt;
                                                            -59.050309709363 days left
                                                    &lt;/span&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/article&gt;
            &lt;/div&gt;

    &lt;div class=&quot;campaigns-pagination&quot;&gt;
        
    &lt;/div&gt;
&lt;/section&gt;
    &lt;/main&gt;

    
    &lt;footer class=&quot;site-footer&quot;&gt;
        &lt;div class=&quot;footer-container&quot;&gt;
            &lt;div class=&quot;footer-grid&quot;&gt;
                &lt;div class=&quot;footer-brand&quot;&gt;
                    &lt;div class=&quot;footer-logo&quot;&gt;
                        &lt;span class=&quot;nav-logo-icon&quot;&gt;&hearts;&lt;/span&gt;
                        &lt;span&gt;CharityHub&lt;/span&gt;
                    &lt;/div&gt;
                    &lt;p class=&quot;footer-desc&quot;&gt;A transparent platform empowering charity organisations to fundraise, manage volunteers, and share their impact with the world.&lt;/p&gt;
                &lt;/div&gt;
                &lt;div class=&quot;footer-links-group&quot;&gt;
                    &lt;h4&gt;Platform&lt;/h4&gt;
                    &lt;a href=&quot;http://localhost/campaigns&quot;&gt;Campaigns&lt;/a&gt;
                    &lt;a href=&quot;#&quot;&gt;Volunteer&lt;/a&gt;
                    &lt;a href=&quot;#&quot;&gt;Impact Reports&lt;/a&gt;
                &lt;/div&gt;
                &lt;div class=&quot;footer-links-group&quot;&gt;
                    &lt;h4&gt;Legal&lt;/h4&gt;
                    &lt;a href=&quot;#&quot;&gt;Privacy Policy&lt;/a&gt;
                    &lt;a href=&quot;#&quot;&gt;Terms of Service&lt;/a&gt;
                    &lt;a href=&quot;#&quot;&gt;GDPR&lt;/a&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;footer-bottom&quot;&gt;
                &lt;p&gt;&amp;copy; 2026 CharityHub. All rights reserved.&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/footer&gt;

    
    &lt;script src=&quot;http://localhost/livewire-da1937c2/livewire.js?id=6b3709b1&quot;   data-csrf=&quot;&quot; data-module-url=&quot;http://localhost/livewire-da1937c2&quot; data-update-uri=&quot;http://localhost/livewire-da1937c2/update&quot; data-navigate-once=&quot;true&quot;&gt;&lt;/script&gt;

    &lt;script&gt;
        // Mobile menu toggle
        document.getElementById(&#039;mobile-menu-btn&#039;)?.addEventListener(&#039;click&#039;, function() {
            document.querySelector(&#039;.nav-links&#039;).classList.toggle(&#039;nav-links-open&#039;);
            this.classList.toggle(&#039;active&#039;);
        });

        // Navbar scroll effect
        window.addEventListener(&#039;scroll&#039;, function() {
            const nav = document.getElementById(&#039;main-nav&#039;);
            if (window.scrollY &gt; 20) {
                nav.classList.add(&#039;nav-scrolled&#039;);
            } else {
                nav.classList.remove(&#039;nav-scrolled&#039;);
            }
        });
    &lt;/script&gt;

    &lt;/body&gt;
&lt;/html&gt;
</code>
 </pre>
    </span>
<span id="execution-results-GETapi-campaigns" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-campaigns"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-campaigns"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-campaigns" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-campaigns">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-campaigns" data-method="GET"
      data-path="api/campaigns"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-campaigns', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-campaigns"
                    onclick="tryItOut('GETapi-campaigns');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-campaigns"
                    onclick="cancelTryOut('GETapi-campaigns');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-campaigns"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/campaigns</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-campaigns"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-campaigns"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-volunteers-register">POST api/volunteers/register</h2>

<p>
</p>



<span id="example-requests-POSTapi-volunteers-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/volunteers/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/volunteers/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-volunteers-register">
</span>
<span id="execution-results-POSTapi-volunteers-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-volunteers-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-volunteers-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-volunteers-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-volunteers-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-volunteers-register" data-method="POST"
      data-path="api/volunteers/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-volunteers-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-volunteers-register"
                    onclick="tryItOut('POSTapi-volunteers-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-volunteers-register"
                    onclick="cancelTryOut('POSTapi-volunteers-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-volunteers-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/volunteers/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-volunteers-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-volunteers-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-volunteers-schedules">GET api/volunteers/schedules</h2>

<p>
</p>



<span id="example-requests-GETapi-volunteers-schedules">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/volunteers/schedules" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/volunteers/schedules"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-volunteers-schedules">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Server Error&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-volunteers-schedules" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-volunteers-schedules"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-volunteers-schedules"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-volunteers-schedules" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-volunteers-schedules">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-volunteers-schedules" data-method="GET"
      data-path="api/volunteers/schedules"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-volunteers-schedules', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-volunteers-schedules"
                    onclick="tryItOut('GETapi-volunteers-schedules');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-volunteers-schedules"
                    onclick="cancelTryOut('GETapi-volunteers-schedules');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-volunteers-schedules"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/volunteers/schedules</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-volunteers-schedules"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-volunteers-schedules"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
