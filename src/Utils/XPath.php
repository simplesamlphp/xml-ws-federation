<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\Utils;

use Dom;
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
     * @param \Dom\Node $node The document to associate to the \Dom\XPath object.
     * @param bool $autoregister Whether to auto-register all namespaces used in the document
     *
     * @return \Dom\XPath A \Dom\XPath object ready to use in the given document, with several
     *   ws-related namespaces already registered.
     */
    public static function getXPath(Dom\Node $node, bool $autoregister = false): Dom\XPath
    {
        $xp = parent::getXPath($node, $autoregister);

        $xp->registerNamespace('auth', C::NS_AUTH);
        $xp->registerNamespace('fed', C::NS_FED);

        return $xp;
    }
}
