function CreateHTTPRequestObject() 
{
    // although IE supports the XMLHttpRequest object, but it does not work on local files.
    var forceActiveX = (window.ActiveXObject && location.protocol === "file:");

    if (window.XMLHttpRequest && !forceActiveX) {
        return new XMLHttpRequest();
    }
    else 
	{
        try 
		{
            return new ActiveXObject("Microsoft.XMLHTTP");
        } 
		catch(e) {}
    }
	
    alert ("Your browser doesn't support XML handling!");
    return null;
}

function CreateMSXMLDocumentObject() 
{
    if (typeof (ActiveXObject) != "undefined") 
	{
        var progIDs = [
                        "Msxml2.DOMDocument.6.0", 
                        "Msxml2.DOMDocument.5.0", 
                        "Msxml2.DOMDocument.4.0", 
                        "Msxml2.DOMDocument.3.0", 
                        "MSXML2.DOMDocument", 
                        "MSXML.DOMDocument"
                      ];
    
	    for (var i = 0; i < progIDs.length; i++) 
		{
            try 
			{ 
                return new ActiveXObject(progIDs[i]); 
            } 
			catch(e) {};
        }
    }
	
    return null;
}

function CreateXMLDocumentObject(rootName) 
{
    if (!rootName) 
	{
        rootName = "";
    }
    
	var xmlDoc = CreateMSXMLDocumentObject();
    
	if (xmlDoc) 
	{
        if (rootName) 
		{
            var rootNode = xmlDoc.createElement (rootName);
            xmlDoc.appendChild (rootNode);
        }
    }
    else 
	{
        if (document.implementation.createDocument) 
		{
            xmlDoc = document.implementation.createDocument ("", rootName, null);
        }
    }
    
    return xmlDoc;
}

function ParseHTTPResponse (httpRequest) 
{
    var xmlDoc = httpRequest.responseXML;

    // if responseXML is not valid, try to create the XML document from the responseText property
    if (!xmlDoc || !xmlDoc.documentElement) 
	{
        if (window.DOMParser) 
		{
            var parser = new DOMParser();
            try 
			{
                xmlDoc = parser.parseFromString (httpRequest.responseText, "text/xml");
            } 
			catch (e) 
			{
                alert('An error has occurred: ' + e.message)
				errorMsg = "XML Parsing Error: " + xmlDoc.parseError.reason
                  + " at line " + xmlDoc.parseError.line
                  + " at position " + xmlDoc.parseError.linepos;
				alert(errorMsg);
                return null;
            };
        }
        else 
		{
            xmlDoc = CreateMSXMLDocumentObject ();
        
		    if (!xmlDoc) 
			{
				alert('ajax.js - ParseHTTPResponse() - xmlDoc is null, returning null');
                return null;
            }
			
            xmlDoc.loadXML (httpRequest.responseText);
        }
    }

    // if there was an error while parsing the XML document
    var errorMsg = null;
	
    if (xmlDoc.parseError && xmlDoc.parseError.errorCode != 0) 
	{
        errorMsg = "XML Parsing Error: " + xmlDoc.parseError.reason
                  + " at line " + xmlDoc.parseError.line
                  + " at position " + xmlDoc.parseError.linepos;
    }
    else 
	{
        if (xmlDoc.documentElement) 
		{
            if (xmlDoc.documentElement.nodeName == "parsererror") 
			{
                errorMsg = xmlDoc.documentElement.childNodes[0].nodeValue;
            }
        }
    }
	
    if (errorMsg) 
	{
        alert (errorMsg);
        return null;
    }

	//alert(XMLtoString(xmlDoc));
	
    // ok, the XML document is valid
    return xmlDoc;
}

// returns whether the HTTP request was successful
function IsRequestSuccessful(httpRequest) 
{
    // IE: sometimes 1223 instead of 204
    var success = (httpRequest.status == 0 || 
        (httpRequest.status >= 200 && httpRequest.status < 300) || 
        httpRequest.status == 304 || httpRequest.status == 1223);
    
    return success;
}

// returns a string containing the XML document. Great for debugging!
function XMLtoString(elem)
{
	var serialized;
	
	try
	{
		// XMLSerializer exists in current Mozilla browsers
		serializer = new XMLSerializer();
		serialized = serializer.serializeToString(elem);
	}
	catch(e)
	{
		// Internet Explorer has a different approach to serializing XML
		serialized = elem.xml;
	}
	
	return serialized;
}

// Useful for walking the XML node tree. Great for debugging!
function traverse(tree)
{
	if (tree.hasChildNodes())
	{
		var nodes = tree.childNodes.length;
		alert('ajax.js - traverse() tree.tagName: ' + tree.tagName);
		
		for (var i=0; i<tree.childNodes.length; i++)
		{
			traverse(tree.childNodes(i));
		}
	}
	else
	{
		alert('ajax.js - traverse() tree.text: ' + tree.text);
	}
}

function getNodeValue(xmlDoc, nodename)
{
	var dataNode = xmlDoc.getElementsByTagName(nodename)[0];

	if (!dataNode)
	{
		alert('ajax.js - Cannot find nodename: ' + nodename + ' in xmlDoc - Call Greg!');
		alert(XMLtoString(xmlDoc));
		return 'error';
	}
	
	var dataValue = dataNode.childNodes[0].nodeValue;
				
	if (!dataValue)
	{
		alert('ajax.js - Cannot retrieve nodeValue for nodename: ' + nodename + ' in xmlDoc - Call Greg!');
		alert(XMLtoString(xmlDoc));
		return 'error';
	}
	
	// alert('ajax.js - getNodeValue(' + nodename + ') = ' + dataValue);
	
	return dataValue;
}

//alert('ajax.js loaded 5');
				