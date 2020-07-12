<?php
//  ------------------------------------------------------------------------ //
//                      SOCIALNET - MODULE FOR XOOPS 2                       //
//                  Copyright (c) 2009-2010  David Yanez Osses               //
//                     <http://www.ipwgc.com/>                      		 //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //


if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

class socialnet_cmimetype
{
   function getType($filename) {
      // get base name of the filename provided by user
      $filename = basename($filename);

      // break file into parts seperated by .
      $filename = explode('.', $filename);

      // take the last part of the file to get the file extension
      $filename = $filename[count($filename)-1];

      // find mime type
      return $this->privFindType($filename);
   }

   function privFindType($ext) {
      // create mimetypes array
      $mimetypes = $this->privBuildMimeArray();

      // return mime type for extension
      if (isset($mimetypes[$ext])) {
         return $mimetypes[$ext];
      // if the extension wasn't found return octet-stream
      } else {
         return 'unknown';
      }

   }

   function privBuildMimeArray() {
      return array(

		 "ez" => "application/andrew-inset",
         "hqx" => "application/mac-binhex40",
         "cpt" => "application/mac-compactpro",
         "doc" => "application/msword",
         "DOC" => "application/msword",
         "Doc" => "application/msword",
         "xls" => "application/vnd.ms-excel",
         "Xls" => "application/vnd.ms-excel",
         "XLS" => "application/vnd.ms-excel",
         "bin" => "application/octet-stream",
         "dms" => "application/octet-stream",
         "lha" => "application/octet-stream",
         "lzh" => "application/octet-stream",
         "exe" => "application/octet-stream",
         "class" => "application/octet-stream",
         "so" => "application/octet-stream",
         "dll" => "application/octet-stream",
         "oda" => "application/oda",
         "pdf" => "application/pdf",
         "PDF" => "application/pdf",
         "Pdf" => "application/pdf",
         "ai" => "application/postscript",
         "eps" => "application/postscript",
         "ps" => "application/postscript",
         "smi" => "application/smil",
         "smil" => "application/smil",
         "wbxml" => "application/vnd.wap.wbxml",
         "wmlc" => "application/vnd.wap.wmlc",
         "wmlsc" => "application/vnd.wap.wmlscriptc",
         "bcpio" => "application/x-bcpio",
         "vcd" => "application/x-cdlink",
         "pgn" => "application/x-chess-pgn",
         "cpio" => "application/x-cpio",
         "csh" => "application/x-csh",
         "dcr" => "application/x-director",
         "dir" => "application/x-director",
         "dxr" => "application/x-director",
         "dvi" => "application/x-dvi",
         "spl" => "application/x-futuresplash",
         "gtar" => "application/x-gtar",
         "hdf" => "application/x-hdf",
         "js" => "application/x-javascript",
         "skp" => "application/x-koan",
         "skd" => "application/x-koan",
         "skt" => "application/x-koan",
         "skm" => "application/x-koan",
         "latex" => "application/x-latex",
         "nc" => "application/x-netcdf",
         "cdf" => "application/x-netcdf",
         "sh" => "application/x-sh",
         "shar" => "application/x-shar",
         "swf" => "application/x-shockwave-flash",
         "sit" => "application/x-stuffit",
         "sv4cpio" => "application/x-sv4cpio",
         "sv4crc" => "application/x-sv4crc",
         "tar" => "application/x-tar",
         "tcl" => "application/x-tcl",
         "tex" => "application/x-tex",
         "texinfo" => "application/x-texinfo",
         "texi" => "application/x-texinfo",
         "t" => "application/x-troff",
         "tr" => "application/x-troff",
         "roff" => "application/x-troff",
         "man" => "application/x-troff-man",
         "me" => "application/x-troff-me",
         "ms" => "application/x-troff-ms",
         "ustar" => "application/x-ustar",
         "src" => "application/x-wais-source",
         "xhtml" => "application/xhtml+xml",
         "xht" => "application/xhtml+xml",
         "zip" => "application/x-zip-compressed",
		 "Zip" => "application/x-zip-compressed",
		 "ZIP" => "application/x-zip-compressed",
         "au" => "audio/basic",
         "XM" => "audio/fasttracker",
         "snd" => "audio/basic",
         "mid" => "audio/midi",
         "midi" => "audio/midi",
         "kar" => "audio/midi",
         "mpga" => "audio/mpeg",
         "mp2" => "audio/mpeg",
         "mp3" => "audio/mpeg",
         "aif" => "audio/x-aiff",
         "aiff" => "audio/x-aiff",
         "aifc" => "audio/x-aiff",
         "m3u" => "audio/x-mpegurl",
         "ram" => "audio/x-pn-realaudio",
         "rm" => "audio/x-pn-realaudio",
         "rpm" => "audio/x-pn-realaudio-plugin",
         "ra" => "audio/x-realaudio",
         "wav" => "audio/x-wav",
         "wax" => "audio/x-windows-media",
         "pdb" => "chemical/x-pdb",
         "xyz" => "chemical/x-xyz",
		 "bmp" => "image/bmp",
         "gif" => "image/gif",
         "ief" => "image/ief",
         "jpeg" => "image/pjpeg",
		 "jpeg" => "image/jpeg",
         "jpg" => "image/jpeg",
         "jpe" => "image/jpeg",
         "png" => "image/x-png",
         "tiff" => "image/tiff",
         "tif" => "image/tif",
         "ico" => "image/icon",
		 "djvu" => "image/vnd.djvu",
         "djv" => "image/vnd.djvu",
         "wbmp" => "image/vnd.wap.wbmp",
         "ras" => "image/x-cmu-raster",
         "pnm" => "image/x-portable-anymap",
         "pbm" => "image/x-portable-bitmap",
         "pgm" => "image/x-portable-graymap",
         "ppm" => "image/x-portable-pixmap",
         "rgb" => "image/x-rgb",
         "xbm" => "image/x-xbitmap",
         "xpm" => "image/x-xpixmap",
         "xwd" => "image/x-windowdump",
         "igs" => "model/iges",
         "iges" => "model/iges",
         "msh" => "model/mesh",
         "mesh" => "model/mesh",
         "silo" => "model/mesh",
         "wrl" => "model/vrml",
         "vrml" => "model/vrml",
         "css" => "text/css",
         "html" => "text/html",
         "htm" => "text/html",
         "asc" => "text/plain",
         "txt" => "text/plain",
		 "Log" => "text/plain",
		 "log" => "text/plain",
         "rtx" => "text/richtext",
         "rtf" => "text/rtf",
         "sgml" => "text/sgml",
         "sgm" => "text/sgml",
         "tsv" => "text/tab-seperated-values",
         "wml" => "text/vnd.wap.wml",
         "wmls" => "text/vnd.wap.wmlscript",
         "etx" => "text/x-setext",
         "xml" => "text/xml",
         "xsl" => "text/xml",
         "mpeg" => "video/mpeg",
         "mpg" => "video/mpeg",
         "mpe" => "video/mpeg",
         "qt" => "video/quicktime",
         "mov" => "video/quicktime",
         "mxu" => "video/vnd.mpegurl",
         "avi" => "video/x-msvideo",
         "movie" => "video/x-sgi-movie",
         "php" => "text/php",
         "php3" => "text/php3",
         "ice" => "x-conference-xcooltalk",
	     "unknown" => "application/octet-stream"
	  );
   }
}
?>