<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\Utils;

use DOMNode;
use DOMXPath;
use SimpleSAML\WebServices\Federation\Constants as C;

/**
 * Compilation of utilities for XPath.
 *
 * @package simplesamlphp/xml-ws-federation
 */
class XPath extends \SimpleSAML\WebServices\Security\Utils\XPath
{
    /*
     * Get a DOMXPath object that can be used to search for WS Federation elements.
     *
     * @param \DOMNode $node The document to associate to the DOMXPath object.
     * @param bool $autoregister Whether to auto-register all namespaces used in the document
     *
     * @return \DOMXPath A DOMXPath object ready to use in the given document, with several
     *   ws-related namespaces already registered.
     */
    public static function getXPath(DOMNode $node, bool $autoregister = false): DOMXPath
    {
        $xp = parent::getXPath($node, $autoregister);

        $xp->registerNamespace('auth', C::NS_AUTH);
        $xp->registerNamespace('fed', C::NS_FED);

        return $xp;
    }
}
