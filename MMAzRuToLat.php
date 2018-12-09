<?php
/*
Plugin Name: AzRuToLatin
Plugin URI: https://github.com/muradmustafayev/WP-AzRuToLatin
Description: Converts Azerbaijani and Russian characters in post slugs to Latin characters. Very useful for Azerbaijani-Russian speaking users of WordPress.
Author: Murad Mustafayev
Contributor: Murad Mustafayev
Author URI: https://muradmustafayev.com
Version: 1.0
*/
 
class MMAzRuToLat {
 
	public function __construct()
	{	
		add_filter('sanitize_title', [$this, 'sanitizeTitle'], 9);
		add_filter('sanitize_file_name', [$this, 'sanitizeTitle']);
	}
  
	public function transliterate($title, $ignore_special_symbols = false)
	{
		$iso9_table = $this->getSymbols();
		
		$title = strtr($title, $iso9_table);

		if(function_exists('iconv'))
		{
			$title = iconv('UTF-8', 'UTF-8//TRANSLIT//IGNORE', $title);
		}

		if(!$ignore_special_symbols)
		{
			$title = preg_replace("/[^A-Za-z0-9'_\-\.]/", '-', $title);
			$title = preg_replace('/\-+/', '-', $title);
			$title = preg_replace('/^-+/', '', $title);
			$title = preg_replace('/-+$/', '', $title);
		}

		return $title;
	}
	
 
	public function sanitizeTitle($title)
	{
		global $wpdb;

		$is_term = false;
		$backtrace = debug_backtrace();
		foreach($backtrace as $backtrace_entry)
		{
			if($backtrace_entry['function'] == 'wp_insert_term')
			{
				$is_term = true;
				break;
			}
		}

		$term = $is_term
			? $wpdb->get_var($wpdb->prepare("SELECT slug FROM {$wpdb->terms} WHERE name = '%s'", $title))
			: '';

		if(empty($term))
		{
			$title = $this->transliterate($title);
		}
		else
		{
			$title = $term;
		}

		return $title;
	}
	
	
	private function getSymbols()
	{
		$az = [
			"ə"=>"e",
			"ü"=>"u",
			"і"=>"i",
			"№"=>"#",
			"ğ"=>"g",
			"ö"=>"o",
			"ı"=>"i",
			"ç"=>"c",
			"ş"=>"s",
			"Ə"=>"E",
			"Ü"=>"U",
			"İ"=>"I",
			"Ğ"=>"G",
			"Ö"=>"O",
			"I"=>"I",
			"Ç"=>"C",
			"Ş"=>"S",
			"—"=>"-",
			"«"=>"",
			"»"=>"",
			"…"=>""
		];
		
		$ru = [
			'А' => 'A',
			'а' => 'a',
			'Б' => 'B',
			'б' => 'b',
			'В' => 'V',
			'в' => 'v',
			'Г' => 'G',
			'г' => 'g',
			'Д' => 'D',
			'д' => 'd',
			'Е' => 'E',
			'е' => 'e',
			'Ё' => 'Jo',
			'ё' => 'jo',
			'Ж' => 'Zh',
			'ж' => 'zh',
			'З' => 'Z',
			'з' => 'z',
			'И' => 'I',
			'и' => 'i',
			'Й' => 'J',
			'й' => 'j',
			'К' => 'K',
			'к' => 'k',
			'Л' => 'L',
			'л' => 'l',
			'М' => 'M',
			'м' => 'm',
			'Н' => 'N',
			'н' => 'n',
			'О' => 'O',
			'о' => 'o',
			'П' => 'P',
			'п' => 'p',
			'Р' => 'R',
			'р' => 'r',
			'С' => 'S',
			'с' => 's',
			'Т' => 'T',
			'т' => 't',
			'У' => 'U',
			'у' => 'u',
			'Ф' => 'F',
			'ф' => 'f',
			'Х' => 'H',
			'х' => 'h',
			'Ц' => 'C',
			'ц' => 'c',
			'Ч' => 'Ch',
			'ч' => 'ch',
			'Ш' => 'Sh',
			'ш' => 'sh',
			'Щ' => 'Shh',
			'щ' => 'shh',
			'Ъ' => '',
			'ъ' => '',
			'Ы' => 'Y',
			'ы' => 'y',
			'Ь' => '',
			'ь' => '',
			'Э' => 'Je',
			'э' => 'je',
			'Ю' => 'Ju',
			'ю' => 'ju',
			'Я' => 'Ja',
			'я' => 'ja',
			
			'Ґ' => 'G',
			'ґ' => 'g',
			'Є' => 'Ie',
			'є' => 'ie',
			'І' => 'I',
			'і' => 'i',
			'Ї' => 'I',
			'ї' => 'i',
			'Ї' => 'i',
			'ї' => 'i',
			'Ё' => 'Jo',
			'ё' => 'jo',
			'й' => 'i',
			'Й' => 'I'
		];
		
		return array_merge($az, $ru);
	}
}

new MMAzRuToLat();

?>
