<?php

/*
 * This file is part of the SgDatatablesBundle package.
 *
 * (c) stwe <https://github.com/stwe/DatatablesBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\DatatablesBundle\Datatable;

use Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Language
 */
class Language
{
    use OptionsTrait;

    /**
     * @var array
     */
    protected $languageCDNFile = [
        'Ganda' => 'Ganda.json',
        'af' => 'af.json',
        'am' => 'am.json',
        'ar' => 'ar.json',
        'az' => 'az-AZ.json',
        'be' => 'be.json',
        'bg' => 'bg.json',
        'bn' => 'bn.json',
        'bs' => 'bs-BA.json',
        'ca' => 'ca.json',
        'co' => 'co.json',
        'cs' => 'cs.json',
        'cy' => 'cy.json',
        'da' => 'da.json',
        'de' => 'de-DE.json',
        'el' => 'el.json',
        'en' => 'en-GB.json',
        'eo' => 'eo.json',
        'es' => 'es-ES.json',
        'es-AR' => 'es-AR.json',
        'es-CL' => 'es-CL.json',
        'es-CO' => 'es-CO.json',
        'es-MX' => 'es-MX.json',
        'et' => 'et.json',
        'eu' => 'eu.json',
        'fa' => 'fa.json',
        'fi' => 'fi.json',
        'fil' => 'fil.json',
        'fr' => 'fr-FR.json',
        'ga' => 'ga.json',
        'gl' => 'gl.json',
        'gu' => 'gu.json',
        'he' => 'he.json',
        'hi' => 'hi.json',
        'hr' => 'hr.json',
        'hu' => 'hu.json',
        'hy' => 'hy.json',
        'id-ALT' => 'id-ALT.json',
        'id' => 'id.json',
        'is' => 'is.json',
        'it' => 'it-IT.json',
        'ja' => 'ja.json',
        'jv' => 'jv.json',
        'ka' => 'ka.json',
        'kk' => 'kk.json',
        'km' => 'km.json',
        'kn' => 'kn.json',
        'ko' => 'ko.json',
        'ku' => 'ku.json',
        'ky' => 'ky.json',
        'lo' => 'lo.json',
        'lt' => 'lt.json',
        'lv' => 'lv.json',
        'mk' => 'mk.json',
        'mn' => 'mn.json',
        'mr' => 'mr.json',
        'ms' => 'ms.json',
        'ne' => 'ne.json',
        'nl' => 'nl-NL.json',
        'no' => 'no-NO.json',
        'no-NB' => 'no-NB.json',
        'pa' => 'pa.json',
        'pl' => 'pl.json',
        'ps' => 'ps.json',
        'pt' => 'pt-PT.json',
        'pt-BR' => 'pt-BR.json',
        'rm' => 'rm.json',
        'ro' => 'ro.json',
        'ru' => 'ru.json',
        'si' => 'si.json',
        'sk' => 'sk.json',
        'sl' => 'sl.json',
        'snd' => 'snd.json',
        'sq' => 'sq.json',
        'sr-SP' => 'sr-SP.json',
        'sr' => 'sr.json',
        'sv' => 'sv-SE.json',
        'sw' => 'sw.json',
        'ta' => 'ta.json',
        'te' => 'te.json',
        'tg' => 'tg.json',
        'th' => 'th.json',
        'tk' => 'tk.json',
        'tr' => 'tr.json',
        'ug' => 'ug.json',
        'uk' => 'uk.json',
        'ur' => 'ur.json',
        'uz-CR' => 'uz-CR.json',
        'uz' => 'uz.json',
        'vi' => 'vi.json',
        'zh-HANT' => 'zh-HANT.json',
        'zh' => 'zh.json',
    ];

    /**
     * Get the actual language file by app.request.locale from CDN.
     * Default: false.
     *
     * @var bool
     */
    protected $cdnLanguageByLocale;

    /**
     * Get the actual language by app.request.locale.
     * Default: false.
     *
     * @var bool
     */
    protected $languageByLocale;

    /**
     * Set a language by given ISO 639-1 code.
     * Default: null.
     *
     * @var string|null
     */
    protected $language;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->initOptions();
    }

    //-------------------------------------------------
    // Options
    //-------------------------------------------------

    /**
     * @return $this
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'cdn_language_by_locale' => false,
            'language_by_locale'     => false,
            'language'               => null,
        ]);

        $resolver->setAllowedTypes('cdn_language_by_locale', 'bool');
        $resolver->setAllowedTypes('language_by_locale', 'bool');
        $resolver->setAllowedTypes('language', ['null', 'string']);

        return $this;
    }

    //-------------------------------------------------
    // Getters && Setters
    //-------------------------------------------------

    /**
     * @return array
     */
    public function getLanguageCDNFile()
    {
        return $this->languageCDNFile;
    }

    /**
     * @return bool
     */
    public function isCdnLanguageByLocale()
    {
        return $this->cdnLanguageByLocale;
    }

    /**
     * @param bool $cdnLanguageByLocale
     *
     * @return $this
     */
    public function setCdnLanguageByLocale($cdnLanguageByLocale)
    {
        $this->cdnLanguageByLocale = $cdnLanguageByLocale;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLanguageByLocale()
    {
        return $this->languageByLocale;
    }

    /**
     * @param bool $languageByLocale
     *
     * @return $this
     */
    public function setLanguageByLocale($languageByLocale)
    {
        $this->languageByLocale = $languageByLocale;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string|null $language
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }
}
