<?php
					
					
					//load the XML document....for using DOM
					$doc = new DOMDocument;
					$doc->load('xml/photoGalleries.xml');
					$xpath = new DOMXPath($doc);
					
					//this function converts a DOM node list to an array
					function dnl2array($domnodelist) {
						$return = array();
						for ($i = 0; $i < $domnodelist->length; ++$i) {
							$return[] = $domnodelist->item($i);
						}
						return $return;
					}
?>