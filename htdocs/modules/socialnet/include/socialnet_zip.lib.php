<?php
/**
 * The Horde_Compress_zip class allows ZIP files to be created and
 * read.
 *
 * $Horde: framework/Compress/Compress/zip.php,v 1.26 2006/03/13 06:13:35 slusarz Exp $
 *
 * The ZIP compression code is partially based on code from:
 *   Eric Mueller <eric@themepark.com>
 *   http://www.zend.com/codex.php?id=535&single=1
 *
 *   Deins125 <webmaster@atlant.ru>
 *   http://www.zend.com/codex.php?id=470&single=1
 *
 * The ZIP compression date code is partially based on code from
 *   Peter Listiak <mlady@users.sourceforge.net>
 *
 * Copyright 2000-2006 Chuck Hagenbuch <chuck@horde.org>
 * Copyright 2002-2006 Michael Cochrane <mike@graftonhall.co.nz>
 * Copyright 2003-2006 Michael Slusarz <slusarz@horde.org>
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Chuck Hagenbuch <chuck@horde.org>
 * @author  Michael Cochrane <mike@graftonhall.co.nz>
 * @author  Michael Slusarz <slusarz@horde.org>
 * @since   Horde 3.0
 * @package Horde_Compress
 */
class Compress_zip
{

    /**
     * ZIP compression methods.
     *
     * @var array
     */
    var $_methods = array(
        0x0 => 'None',
        0x1 => 'Shrunk',
        0x2 => 'Super Fast',
        0x3 => 'Fast',
        0x4 => 'Normal',
        0x5 => 'Maximum',
        0x6 => 'Imploded',
        0x8 => 'Deflated'
    );

    /**
     * Beginning of central directory record.
     *
     * @var string
     */
    var $_ctrlDirHeader = "\x50\x4b\x01\x02";

    /**
     * End of central directory record.
     *
     * @var string
     */
    var $_ctrlDirEnd = "\x50\x4b\x05\x06\x00\x00\x00\x00";

    /**
     * Beginning of file contents.
     *
     * @var string
     */
    var $_fileHeader = "\x50\x4b\x03\x04";

    /**
     * Create a ZIP compressed file from an array of file data.
     *
     * @param array $data    The data to compress.
     * <pre>
     * Requires an array of arrays - each sub array should contain the
     * following fields:
     * 'data' (string)   --  The data to compress.
     * 'name' (string)   --  The pathname to the file.
     * 'time' (integer)  --  [optional] The timestamp to use for the file.
     * </pre>
     * @param array $params  The parameter array (Unused).
     *
     * @return string  The ZIP file.
     */
    function compress($data, $params = array())
    {
        $contents = $ctrldir = array();

        foreach ($data as $val) {
            $this->_addToZIPFile($val, $contents, $ctrldir);
        }

        return $this->_createZIPFile($contents, $ctrldir);
    }

    /**
     * Converts a UNIX timestamp to a 4-byte DOS date and time format
     * (date in high 2-bytes, time in low 2-bytes allowing magnitude
     * comparison).
     *
     * @access private
     *
     * @param integer $unixtime  The current UNIX timestamp.
     *
     * @return integer  The current date in a 4-byte DOS format.
     */
    function _unix2DOSTime($unixtime = null)
    {
        $timearray = (is_null($unixtime)) ? getdate() : getdate($unixtime);

        if ($timearray['year'] < 1980) {
            $timearray['year']    = 1980;
            $timearray['mon']     = 1;
            $timearray['mday']    = 1;
            $timearray['hours']   = 0;
            $timearray['minutes'] = 0;
            $timearray['seconds'] = 0;
        }

        return (($timearray['year'] - 1980) << 25) |
                ($timearray['mon'] << 21) |
                ($timearray['mday'] << 16) |
                ($timearray['hours'] << 11) |
                ($timearray['minutes'] << 5) |
                ($timearray['seconds'] >> 1);
    }

    /**
     * Adds a "file" to the ZIP archive.
     *
     * @access private
     *
     * @param array &$file      See Horde_Compress_zip::createZipFile().
     * @param array &$contents  An array of existing zipped files.
     * @param array &$ctrldir   An array of central directory information.
     */
    function _addToZIPFile(&$file, &$contents, &$ctrldir)
    {
        $data = &$file['data'];
        $name = str_replace('\\', '/', $file['name']);

        /* See if time/date information has been provided. */
        $ftime = null;
        if (isset($file['time'])) {
            $ftime = $file['time'];
        }

        /* Get the hex time. */
        $dtime    = dechex($this->_unix2DosTime($ftime));
        $hexdtime = chr(hexdec($dtime[6] . $dtime[7])) .
                    chr(hexdec($dtime[4] . $dtime[5])) .
                    chr(hexdec($dtime[2] . $dtime[3])) .
                    chr(hexdec($dtime[0] . $dtime[1]));

        $fr  = $this->_fileHeader;   /* Begin creating the ZIP data. */
        $fr .= "\x14\x00";           /* Version needed to extract. */
        $fr .= "\x00\x00";           /* General purpose bit flag. */
        $fr .= "\x08\x00";           /* Compression method. */
        $fr .= $hexdtime;            /* Last modification time/date. */

        /* "Local file header" segment. */
        $unc_len = strlen($data);
        $crc     = crc32($data);
        $zdata   = gzcompress($data);
        $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
        $c_len   = strlen($zdata);

        $fr .= pack('V', $crc);            /* CRC 32 information. */
        $fr .= pack('V', $c_len);          /* Compressed filesize. */
        $fr .= pack('V', $unc_len);        /* Uncompressed filesize. */
        $fr .= pack('v', strlen($name));   /* Length of filename. */
        $fr .= pack('v', 0);               /* Extra field length. */
        $fr .= $name;                      /* File name. */

        /* "File data" segment. */
        $fr .= $zdata;

        /* "Data descriptor" segment (optional but necessary if archive is
           not served as file). */
        $fr .= pack('V', $crc);
        $fr .= pack('V', $c_len);
        $fr .= pack('V', $unc_len);

        /* Add this entry to array. */
        $old_offset = strlen(implode('', $contents));
        $contents[] = &$fr;

        /* Add to central directory record. */
        $cdrec  = $this->_ctrlDirHeader;
        $cdrec .= "\x00\x00";                /* Version made by. */
        $cdrec .= "\x14\x00";                /* Version needed to extract */
        $cdrec .= "\x00\x00";                /* General purpose bit flag */
        $cdrec .= "\x08\x00";                /* Compression method */
        $cdrec .= $hexdtime;                 /* Last mod time/date. */
        $cdrec .= pack('V', $crc);           /* CRC 32 information. */
        $cdrec .= pack('V', $c_len);         /* Compressed filesize. */
        $cdrec .= pack('V', $unc_len);       /* Uncompressed filesize. */
        $cdrec .= pack('v', strlen($name));  /* Length of filename. */
        $cdrec .= pack('v', 0);              /* Extra field length. */
        $cdrec .= pack('v', 0);              /* File comment length. */
        $cdrec .= pack('v', 0);              /* Disk number start. */
        $cdrec .= pack('v', 0);              /* Internal file attributes. */
        $cdrec .= pack('V', 32);             /* External file attributes -
                                                'archive' bit set. */
        $cdrec .= pack('V', $old_offset);    /* Relative offset of local
                                                header. */
        $cdrec .= $name;                     /* File name. */
        /* Optional extra field, file comment goes here. */

        // Save to central directory array. */
        $ctrldir[] = &$cdrec;
    }

    /**
     * Creates the ZIP file.
     * Official ZIP file format: http://www.pkware.com/appnote.txt
     *
     * @access private
     *
     * @return string  The ZIP file.
     */
    function _createZIPFile(&$contents, &$ctrlDir)
    {
        $data = implode('', $contents);
        $dir = implode('', $ctrlDir);

        return $data . $dir . $this->_ctrlDirEnd .
            /* Total # of entries "on this disk". */
            pack('v', count($ctrlDir)) .
            /* Total # of entries overall. */
            pack('v', count($ctrlDir)) .
            /* Size of central directory. */
            pack('V', strlen($dir)) .
            /* Offset to start of central dir. */
            pack('V', strlen($data)) .
            /* ZIP file comment length. */
            "\x00\x00";
    }

}