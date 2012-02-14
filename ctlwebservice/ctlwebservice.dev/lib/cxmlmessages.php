<?php
	/*
	 * CXmlMessages: this class centrally locates various xml
	 * messages that are need in the CtlWebService application.
	 *
	 * NOTE: the C in this class stands for Ctl or Controller.
	 */
	class CXmlMessages
	{
		static public function getParameterNotSet($parameterName, $statusReport, $fileName, $lineNumber, $otherInfo)
		{
			$retXML = '<?xml version="1.0" ?>'."\n";

			$retXML .= '<ctlwebservicemessage>'."\n";
			$retXML .= '<status>';
			$retXML .= $statusReport;
			$retXML .= '</status>'."\n";

			$retXML .= '<reason>';
			$retXML .= __METHOD__;
			$retXML .= '</reason>'."\n";

			$retXML .= '<phpfilename>';
			$retXML .= $fileName;
			$retXML .= '</phpfilename>'."\n";

			$retXML .= '<phplinenumber>';
			$retXML .= $lineNumber;
			$retXML .= '</phplinenumber>'."\n";

			$retXML .= '<otherinfo>';
			$retXML .= $otherInfo;
			$retXML .= '</otherinfo>'."\n";

			$retXML .= '</ctlwebservicemessage>';
			return $retXML;

		}
		static public function soapExceptionGenerated($statusReport, $fileName, $lineNumber, $otherInfo)
		{
			$retXML = '<?xml version="1.0" ?>'."\n";

			$retXML .= '<ctlwebservicemessage>'."\n";
			$retXML .= '<status>';
			$retXML .= $statusReport;
			$retXML .= '</status>'."\n";

			$retXML .= '<reason>';
			$retXML .= __METHOD__;
			$retXML .= '</reason>'."\n";

			$retXML .= '<phpfilename>';
			$retXML .= $fileName;
			$retXML .= '</phpfilename>'."\n";

			$retXML .= '<phplinenumber>';
			$retXML .= $lineNumber;
			$retXML .= '</phplinenumber>'."\n";

			$retXML .= '<otherinfo>';
			$retXML .= $otherInfo;
			$retXML .= '</otherinfo>'."\n";

			$retXML .= '</ctlwebservicemessage>';
			return $retXML;
		}
	}
?>
