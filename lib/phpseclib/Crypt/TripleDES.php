<?php
 if(!class_exists('Crypt_DES')){require_once('DES.php');}define('CRYPT_DES_MODE_3CBC',-2);define('CRYPT_DES_MODE_CBC3',CRYPT_DES_MODE_CBC);class Crypt_TripleDES{var $key="\0\0\0\0\0\0\0\0";var $mode=CRYPT_DES_MODE_CBC;var $continuousBuffer=false;var $padding=true;var $iv="\0\0\0\0\0\0\0\0";var $encryptIV="\0\0\0\0\0\0\0\0";var $decryptIV="\0\0\0\0\0\0\0\0";var $des;var $enmcrypt;var $demcrypt;var $enchanged=true;var $dechanged=true;var $paddable=false;var $enbuffer='';var $debuffer='';var $ecb;function Crypt_TripleDES($mode=CRYPT_DES_MODE_CBC){if(!defined('CRYPT_DES_MODE')){switch(true){case  extension_loaded('mcrypt')&&in_array('tripledes',mcrypt_list_algorithms()):define('CRYPT_DES_MODE',CRYPT_DES_MODE_MCRYPT);break;default:define('CRYPT_DES_MODE',CRYPT_DES_MODE_INTERNAL);}}if($mode==CRYPT_DES_MODE_3CBC){$this->mode=CRYPT_DES_MODE_3CBC;$this->des=array(new Crypt_DES(CRYPT_DES_MODE_CBC),new Crypt_DES(CRYPT_DES_MODE_CBC),new Crypt_DES(CRYPT_DES_MODE_CBC));$this->paddable=true;$this->des[0]->disablePadding();$this->des[1]->disablePadding();$this->des[2]->disablePadding();return;}switch(CRYPT_DES_MODE){case  CRYPT_DES_MODE_MCRYPT:switch($mode){case  CRYPT_DES_MODE_ECB:$this->paddable=true;$this->mode=MCRYPT_MODE_ECB;break;case  CRYPT_DES_MODE_CTR:$this->mode='ctr';break;case  CRYPT_DES_MODE_CFB:$this->mode='ncfb';break;case  CRYPT_DES_MODE_OFB:$this->mode=MCRYPT_MODE_NOFB;break;case  CRYPT_DES_MODE_CBC:default:$this->paddable=true;$this->mode=MCRYPT_MODE_CBC;}break;default:$this->des=array(new Crypt_DES(CRYPT_DES_MODE_ECB),new Crypt_DES(CRYPT_DES_MODE_ECB),new Crypt_DES(CRYPT_DES_MODE_ECB));$this->des[0]->disablePadding();$this->des[1]->disablePadding();$this->des[2]->disablePadding();switch($mode){case  CRYPT_DES_MODE_ECB:case  CRYPT_DES_MODE_CBC:$this->paddable=true;$this->mode=$mode;break;case  CRYPT_DES_MODE_CTR:case  CRYPT_DES_MODE_CFB:case  CRYPT_DES_MODE_OFB:$this->mode=$mode;break;default:$this->paddable=true;$this->mode=CRYPT_DES_MODE_CBC;}}}function setKey($key){$length=strlen($key);if($length>8){$key=str_pad($key,24,chr(0));}else{$key=str_pad($key,8,chr(0));}$this->key=$key;switch(true){case  CRYPT_DES_MODE==CRYPT_DES_MODE_INTERNAL:case  $this->mode==CRYPT_DES_MODE_3CBC:$this->des[0]->setKey(substr($key,0,8));$this->des[1]->setKey(substr($key,8,8));$this->des[2]->setKey(substr($key,16,8));}$this->enchanged=$this->dechanged=true;}function setPassword($password,$method='pbkdf2'){$key='';switch($method){default:list(,,$hash,$salt,$count)=func_get_args();if(!isset($hash)){$hash='sha1';}if(!isset($salt)){$salt='phpseclib';}if(!isset($count)){$count=1000;}if(!class_exists('Crypt_Hash')){require_once('Crypt/Hash.php');}$i=1;while(strlen($key)<24){$hmac=new Crypt_Hash();$hmac->setHash($hash);$hmac->setKey($password);$f=$u=$hmac->hash($salt.pack('N',$i++));for($j=2;$j<=$count;$j++){$u=$hmac->hash($u);$f^=$u;}$key.=$f;}}$this->setKey($key);}function setIV($iv){$this->encryptIV=$this->decryptIV=$this->iv=str_pad(substr($iv,0,8),8,chr(0));if($this->mode==CRYPT_DES_MODE_3CBC){$this->des[0]->setIV($iv);$this->des[1]->setIV($iv);$this->des[2]->setIV($iv);}$this->enchanged=$this->dechanged=true;}function _generate_xor($length,&$iv){$xor='';$num_blocks=($length+7)>>3;for($i=0;$i<$num_blocks;$i++){$xor.=$iv;for($j=4;$j<=8;$j+=4){$temp=substr($iv,-$j,4);switch($temp){case  "\xFF\xFF\xFF\xFF":$iv=substr_replace($iv,"\x00\x00\x00\x00",-$j,4);break;case  "\x7F\xFF\xFF\xFF":$iv=substr_replace($iv,"\x80\x00\x00\x00",-$j,4);break2;default:extract(unpack('Ncount',$temp));$iv=substr_replace($iv,pack('N',$count+1),-$j,4);break2;}}}return $xor;}function encrypt($plaintext){if($this->paddable){$plaintext=$this->_pad($plaintext);}if($this->mode==CRYPT_DES_MODE_3CBC&&strlen($this->key)>8){$ciphertext=$this->des[2]->encrypt($this->des[1]->decrypt($this->des[0]->encrypt($plaintext)));return $ciphertext;}if(CRYPT_DES_MODE==CRYPT_DES_MODE_MCRYPT){if($this->enchanged){if(!isset($this->enmcrypt)){$this->enmcrypt=mcrypt_module_open(MCRYPT_3DES,'',$this->mode,'');}mcrypt_generic_init($this->enmcrypt,$this->key,$this->encryptIV);if($this->mode!='ncfb'){$this->enchanged=false;}}if($this->mode!='ncfb'){$ciphertext=mcrypt_generic($this->enmcrypt,$plaintext);}else{if($this->enchanged){$this->ecb=mcrypt_module_open(MCRYPT_3DES,'',MCRYPT_MODE_ECB,'');mcrypt_generic_init($this->ecb,$this->key,"\0\0\0\0\0\0\0\0");$this->enchanged=false;}if(strlen($this->enbuffer)){$ciphertext=$plaintext^substr($this->encryptIV,strlen($this->enbuffer));$this->enbuffer.=$ciphertext;if(strlen($this->enbuffer)==8){$this->encryptIV=$this->enbuffer;$this->enbuffer='';mcrypt_generic_init($this->enmcrypt,$this->key,$this->encryptIV);}$plaintext=substr($plaintext,strlen($ciphertext));}else{$ciphertext='';}$last_pos=strlen($plaintext)&0xFFFFFFF8;$ciphertext.=$last_pos?mcrypt_generic($this->enmcrypt,substr($plaintext,0,$last_pos)):'';if(strlen($plaintext)&0x7){if(strlen($ciphertext)){$this->encryptIV=substr($ciphertext,-8);}$this->encryptIV=mcrypt_generic($this->ecb,$this->encryptIV);$this->enbuffer=substr($plaintext,$last_pos)^$this->encryptIV;$ciphertext.=$this->enbuffer;}}if(!$this->continuousBuffer){mcrypt_generic_init($this->enmcrypt,$this->key,$this->encryptIV);}return $ciphertext;}if(strlen($this->key)<=8){$this->des[0]->mode=$this->mode;return $this->des[0]->encrypt($plaintext);}$des=$this->des;$buffer=&$this->enbuffer;$continuousBuffer=$this->continuousBuffer;$ciphertext='';switch($this->mode){case  CRYPT_DES_MODE_ECB:for($i=0;$i<strlen($plaintext);$i+=8){$block=substr($plaintext,$i,8);$block=$des[0]->_processBlock($block,CRYPT_DES_ENCRYPT);$block=$des[1]->_processBlock($block,CRYPT_DES_DECRYPT);$block=$des[2]->_processBlock($block,CRYPT_DES_ENCRYPT);$ciphertext.=$block;}break;case  CRYPT_DES_MODE_CBC:$xor=$this->encryptIV;for($i=0;$i<strlen($plaintext);$i+=8){$block=substr($plaintext,$i,8)^$xor;$block=$des[0]->_processBlock($block,CRYPT_DES_ENCRYPT);$block=$des[1]->_processBlock($block,CRYPT_DES_DECRYPT);$block=$des[2]->_processBlock($block,CRYPT_DES_ENCRYPT);$xor=$block;$ciphertext.=$block;}if($this->continuousBuffer){$this->encryptIV=$xor;}break;case  CRYPT_DES_MODE_CTR:$xor=$this->encryptIV;if(strlen($buffer['encrypted'])){for($i=0;$i<strlen($plaintext);$i+=8){$block=substr($plaintext,$i,8);$key=$this->_generate_xor(8,$xor);$key=$des[0]->_processBlock($key,CRYPT_DES_ENCRYPT);$key=$des[1]->_processBlock($key,CRYPT_DES_DECRYPT);$key=$des[2]->_processBlock($key,CRYPT_DES_ENCRYPT);$buffer['encrypted'].=$key;$key=$this->_string_shift($buffer['encrypted'],8);$ciphertext.=$block^$key;}}else{for($i=0;$i<strlen($plaintext);$i+=8){$block=substr($plaintext,$i,8);$key=$this->_generate_xor(8,$xor);$key=$des[0]->_processBlock($key,CRYPT_DES_ENCRYPT);$key=$des[1]->_processBlock($key,CRYPT_DES_DECRYPT);$key=$des[2]->_processBlock($key,CRYPT_DES_ENCRYPT);$ciphertext.=$block^$key;}}if($this->continuousBuffer){$this->encryptIV=$xor;if($start=strlen($plaintext)&7){$buffer['encrypted']=substr($key,$start).$buffer;}}break;case  CRYPT_DES_MODE_CFB:if(!empty($buffer['xor'])){$ciphertext=$plaintext^$buffer['xor'];$iv=$buffer['encrypted'].$ciphertext;$start=strlen($ciphertext);$buffer['encrypted'].=$ciphertext;$buffer['xor']=substr($buffer['xor'],strlen($ciphertext));}else{$ciphertext='';$iv=$this->encryptIV;$start=0;}for($i=$start;$i<strlen($plaintext);$i+=8){$block=substr($plaintext,$i,8);$iv=$des[0]->_processBlock($iv,CRYPT_DES_ENCRYPT);$iv=$des[1]->_processBlock($iv,CRYPT_DES_DECRYPT);$xor=$des[2]->_processBlock($iv,CRYPT_DES_ENCRYPT);$iv=$block^$xor;if($continuousBuffer&&strlen($iv)!=8){$buffer=array('encrypted'=>$iv,'xor'=>substr($xor,strlen($iv)));}$ciphertext.=$iv;}if($this->continuousBuffer){$this->encryptIV=$iv;}break;case  CRYPT_DES_MODE_OFB:$xor=$this->encryptIV;if(strlen($buffer)){for($i=0;$i<strlen($plaintext);$i+=8){$xor=$des[0]->_processBlock($xor,CRYPT_DES_ENCRYPT);$xor=$des[1]->_processBlock($xor,CRYPT_DES_DECRYPT);$xor=$des[2]->_processBlock($xor,CRYPT_DES_ENCRYPT);$buffer.=$xor;$key=$this->_string_shift($buffer,8);$ciphertext.=substr($plaintext,$i,8)^$key;}}else{for($i=0;$i<strlen($plaintext);$i+=8){$xor=$des[0]->_processBlock($xor,CRYPT_DES_ENCRYPT);$xor=$des[1]->_processBlock($xor,CRYPT_DES_DECRYPT);$xor=$des[2]->_processBlock($xor,CRYPT_DES_ENCRYPT);$ciphertext.=substr($plaintext,$i,8)^$xor;}$key=$xor;}if($this->continuousBuffer){$this->encryptIV=$xor;if($start=strlen($plaintext)&7){$buffer=substr($key,$start).$buffer;}}}return $ciphertext;}function decrypt($ciphertext){if($this->mode==CRYPT_DES_MODE_3CBC&&strlen($this->key)>8){$plaintext=$this->des[0]->decrypt($this->des[1]->encrypt($this->des[2]->decrypt($ciphertext)));return $this->_unpad($plaintext);}if($this->paddable){$ciphertext=str_pad($ciphertext,(strlen($ciphertext)+7)&0xFFFFFFF8,chr(0));}if(CRYPT_DES_MODE==CRYPT_DES_MODE_MCRYPT){if($this->dechanged){if(!isset($this->demcrypt)){$this->demcrypt=mcrypt_module_open(MCRYPT_3DES,'',$this->mode,'');}mcrypt_generic_init($this->demcrypt,$this->key,$this->decryptIV);if($this->mode!='ncfb'){$this->dechanged=false;}}if($this->mode!='ncfb'){$plaintext=mdecrypt_generic($this->demcrypt,$ciphertext);}else{if($this->dechanged){$this->ecb=mcrypt_module_open(MCRYPT_3DES,'',MCRYPT_MODE_ECB,'');mcrypt_generic_init($this->ecb,$this->key,"\0\0\0\0\0\0\0\0");$this->dechanged=false;}if(strlen($this->debuffer)){$plaintext=$ciphertext^substr($this->decryptIV,strlen($this->debuffer));$this->debuffer.=substr($ciphertext,0,strlen($plaintext));if(strlen($this->debuffer)==8){$this->decryptIV=$this->debuffer;$this->debuffer='';mcrypt_generic_init($this->demcrypt,$this->key,$this->decryptIV);}$ciphertext=substr($ciphertext,strlen($plaintext));}else{$plaintext='';}$last_pos=strlen($ciphertext)&0xFFFFFFF8;$plaintext.=$last_pos?mdecrypt_generic($this->demcrypt,substr($ciphertext,0,$last_pos)):'';if(strlen($ciphertext)&0x7){if(strlen($plaintext)){$this->decryptIV=substr($ciphertext,$last_pos-8,8);}$this->decryptIV=mcrypt_generic($this->ecb,$this->decryptIV);$this->debuffer=substr($ciphertext,$last_pos);$plaintext.=$this->debuffer^$this->decryptIV;}return $plaintext;}if(!$this->continuousBuffer){mcrypt_generic_init($this->demcrypt,$this->key,$this->decryptIV);}return $this->paddable?$this->_unpad($plaintext):$plaintext;}if(strlen($this->key)<=8){$this->des[0]->mode=$this->mode;$plaintext=$this->des[0]->decrypt($ciphertext);return $this->paddable?$this->_unpad($plaintext):$plaintext;}$des=$this->des;$buffer=&$this->enbuffer;$continuousBuffer=$this->continuousBuffer;$plaintext='';switch($this->mode){case  CRYPT_DES_MODE_ECB:for($i=0;$i<strlen($ciphertext);$i+=8){$block=substr($ciphertext,$i,8);$block=$des[2]->_processBlock($block,CRYPT_DES_DECRYPT);$block=$des[1]->_processBlock($block,CRYPT_DES_ENCRYPT);$block=$des[0]->_processBlock($block,CRYPT_DES_DECRYPT);$plaintext.=$block;}break;case  CRYPT_DES_MODE_CBC:$xor=$this->decryptIV;for($i=0;$i<strlen($ciphertext);$i+=8){$orig=$block=substr($ciphertext,$i,8);$block=$des[2]->_processBlock($block,CRYPT_DES_DECRYPT);$block=$des[1]->_processBlock($block,CRYPT_DES_ENCRYPT);$block=$des[0]->_processBlock($block,CRYPT_DES_DECRYPT);$plaintext.=$block^$xor;$xor=$orig;}if($this->continuousBuffer){$this->decryptIV=$xor;}break;case  CRYPT_DES_MODE_CTR:$xor=$this->decryptIV;if(strlen($buffer['ciphertext'])){for($i=0;$i<strlen($ciphertext);$i+=8){$block=substr($ciphertext,$i,8);$key=$this->_generate_xor(8,$xor);$key=$des[0]->_processBlock($key,CRYPT_DES_ENCRYPT);$key=$des[1]->_processBlock($key,CRYPT_DES_DECRYPT);$key=$des[2]->_processBlock($key,CRYPT_DES_ENCRYPT);$buffer['ciphertext'].=$key;$key=$this->_string_shift($buffer['ciphertext'],8);$plaintext.=$block^$key;}}else{for($i=0;$i<strlen($ciphertext);$i+=8){$block=substr($ciphertext,$i,8);$key=$this->_generate_xor(8,$xor);$key=$des[0]->_processBlock($key,CRYPT_DES_ENCRYPT);$key=$des[1]->_processBlock($key,CRYPT_DES_DECRYPT);$key=$des[2]->_processBlock($key,CRYPT_DES_ENCRYPT);$plaintext.=$block^$key;}}if($this->continuousBuffer){$this->decryptIV=$xor;if($start=strlen($plaintext)&7){$buffer['ciphertext']=substr($key,$start).$buffer['ciphertext'];}}break;case  CRYPT_DES_MODE_CFB:if(!empty($buffer['ciphertext'])){$plaintext=$ciphertext^substr($this->decryptIV,strlen($buffer['ciphertext']));$buffer['ciphertext'].=substr($ciphertext,0,strlen($plaintext));if(strlen($buffer['ciphertext'])==8){$xor=$des[0]->_processBlock($buffer['ciphertext'],CRYPT_DES_ENCRYPT);$xor=$des[1]->_processBlock($xor,CRYPT_DES_DECRYPT);$xor=$des[2]->_processBlock($xor,CRYPT_DES_ENCRYPT);$buffer['ciphertext']='';}$start=strlen($plaintext);$block=$this->decryptIV;}else{$plaintext='';$xor=$des[0]->_processBlock($this->decryptIV,CRYPT_DES_ENCRYPT);$xor=$des[1]->_processBlock($xor,CRYPT_DES_DECRYPT);$xor=$des[2]->_processBlock($xor,CRYPT_DES_ENCRYPT);$start=0;}for($i=$start;$i<strlen($ciphertext);$i+=8){$block=substr($ciphertext,$i,8);$plaintext.=$block^$xor;if($continuousBuffer&&strlen($block)!=8){$buffer['ciphertext'].=$block;$block=$xor;}else if(strlen($block)==8){$xor=$des[0]->_processBlock($block,CRYPT_DES_ENCRYPT);$xor=$des[1]->_processBlock($xor,CRYPT_DES_DECRYPT);$xor=$des[2]->_processBlock($xor,CRYPT_DES_ENCRYPT);}}if($this->continuousBuffer){$this->decryptIV=$block;}break;case  CRYPT_DES_MODE_OFB:$xor=$this->decryptIV;if(strlen($buffer)){for($i=0;$i<strlen($ciphertext);$i+=8){$xor=$des[0]->_processBlock($xor,CRYPT_DES_ENCRYPT);$xor=$des[1]->_processBlock($xor,CRYPT_DES_DECRYPT);$xor=$des[2]->_processBlock($xor,CRYPT_DES_ENCRYPT);$buffer.=$xor;$key=$this->_string_shift($buffer,8);$plaintext.=substr($ciphertext,$i,8)^$key;}}else{for($i=0;$i<strlen($ciphertext);$i+=8){$xor=$des[0]->_processBlock($xor,CRYPT_DES_ENCRYPT);$xor=$des[1]->_processBlock($xor,CRYPT_DES_DECRYPT);$xor=$des[2]->_processBlock($xor,CRYPT_DES_ENCRYPT);$plaintext.=substr($ciphertext,$i,8)^$xor;}$key=$xor;}if($this->continuousBuffer){$this->decryptIV=$xor;if($start=strlen($ciphertext)&7){$buffer=substr($key,$start).$buffer;}}}return $this->paddable?$this->_unpad($plaintext):$plaintext;}function enableContinuousBuffer(){$this->continuousBuffer=true;if($this->mode==CRYPT_DES_MODE_3CBC){$this->des[0]->enableContinuousBuffer();$this->des[1]->enableContinuousBuffer();$this->des[2]->enableContinuousBuffer();}}function disableContinuousBuffer(){$this->continuousBuffer=false;$this->encryptIV=$this->iv;$this->decryptIV=$this->iv;if($this->mode==CRYPT_DES_MODE_3CBC){$this->des[0]->disableContinuousBuffer();$this->des[1]->disableContinuousBuffer();$this->des[2]->disableContinuousBuffer();}}function enablePadding(){$this->padding=true;}function disablePadding(){$this->padding=false;}function _pad($text){$length=strlen($text);if(!$this->padding){if(($length&7)==0){return $text;}else{user_error("The plaintext's length ($length) is not a multiple of the block size (8)",E_USER_NOTICE);$this->padding=true;}}$pad=8-($length&7);return str_pad($text,$length+$pad,chr($pad));}function _unpad($text){if(!$this->padding){return $text;}$length=ord($text[strlen($text)-1]);if(!$length||$length>8){return false;}return substr($text,0,-$length);}function _string_shift(&$string,$index=1){$substr=substr($string,0,$index);$string=substr($string,$index);return $substr;}}