<?php

/**
 * Klasse zum objektorientierten Schreiben von Excel XML-Dateien. Die Klassen beinhaltet folgende Funktionen:
 * 
 * setWorksheetName()	Setzen von Worksheetnamen
 * createStyle()		Definition von Formatierungen
 * writeData()			Text in Zellen schreiben
 * writeFormula()		Formeln in Zellen schreiben
 * getFile()			XML-Excel-Datei zurückgeben
 * 
 * Wichtig ist, dass jede Zeile der Reihe nach von links nach recht befüllt werden muss. Späteres Einfügen von
 * Zellen links neben einer bereits erstellten Zelle ist nicht möglich! Zeilen können jedoch in beliebiger
 * Reihenfolge erstellt werden.
 *
 * @author Karsten Spiekermann
 **/
class LegosXmlWriter extends DOMDocument {
	private $xml; // Das XML-Dokument
	
	/**
	 * Die PHP DOMDocument-Klasse initialisieren
	 */
	function __construct() {
		// Die Mutterklasse DOMDocument hat vielleicht auch etwas zu initialisieren
		parent::__construct ();
		
		// DOMDocument erstellen. Das ist eine PHP-Klasse für HTML- und XML-Dokumente
		$this->xml = new DOMDocument ();
		
		// XML-Definitionen für den Rahmen der Excel-Datei erstellen
		self::frame_init ();
	}
	
	/**
	 * Diese Funktion erstellt den Grundrahmen der Excel-Datei.
	 */
	public function frame_init() {
		$this->xml->formatOutput = true;
		$this->xml->preserveWhitespace = false;
		
		$info = $this->xml->createDocumentFragment ();
		$info->appendXML ( "<?mso-application progid='Excel.Sheet' ?>" );
		$this->xml->appendChild ( $info );
		
		// Ebene Workbook
		$root = $this->xml->createElement ( 'Workbook' );
		$this->xml->appendChild ( $root );
		$attr1 = $this->xml->createAttribute ( 'xmlns' );
		$root->appendChild ( $attr1 );
		$attr1->appendChild ( $this->xml->createTextNode ( 'urn:schemas-microsoft-com:office:spreadsheet' ) );
		$attr2 = $this->xml->createAttribute ( 'xmlns:o' );
		$root->appendChild ( $attr2 );
		$attr2->appendChild ( $this->xml->createTextNode ( 'urn:schemas-microsoft-com:office:office' ) );
		$attr3 = $this->xml->createAttribute ( 'xmlns:x' );
		$root->appendChild ( $attr3 );
		$attr3->appendChild ( $this->xml->createTextNode ( 'urn:schemas-microsoft-com:office:excel' ) );
		$attr4 = $this->xml->createAttribute ( 'xmlns:ss' );
		$root->appendChild ( $attr4 );
		$attr4->appendChild ( $this->xml->createTextNode ( 'urn:schemas-microsoft-com:office:spreadsheet' ) );
		$attr5 = $this->xml->createAttribute ( 'xmlns:html' );
		$root->appendChild ( $attr5 );
		$attr5->appendChild ( $this->xml->createTextNode ( 'http://www.w3.org/TR/REC-html40' ) );
		
		// Ebene DocumentProperties
		$document_properties = $this->xml->createElementNS ( 'urn:schemas-microsoft-com:office:spreadsheet', 'DocumentProperties' );
		$document_properties = $root->appendChild ( $document_properties );
		// DocumentProperties - Author
		$author = $this->xml->createElement ( 'Author' );
		$document_properties->appendChild ( $author );
		$author->appendChild ( $this->xml->createTextNode ( 'Legos2' ) );
		// DocumentProperties - LastAuthor
		$last_author = $this->xml->createElement ( 'LastAuthor' );
		$document_properties->appendChild ( $last_author );
		$last_author->appendChild ( $this->xml->createTextNode ( 'Legos2' ) );
		// DocumentProperties - Created
		$created = $this->xml->createElement ( 'Created' );
		$document_properties->appendChild ( $created );
		$created->appendChild ( $this->xml->createTextNode ( '2007-03-15T23:04:04Z' ) );
		// DocumentProperties - Company
		$company = $this->xml->createElement ( 'Company' );
		$document_properties->appendChild ( $company );
		$company->appendChild ( $this->xml->createTextNode ( 'Lufthansa LEOS' ) );
		// DocumentProperties - Version
		$version = $this->xml->createElement ( 'Version' );
		$document_properties->appendChild ( $version );
		$version->appendChild ( $this->xml->createTextNode ( '1' ) );
		
		// Ebene ExcelWorkbook
		$excelworkbook = $this->xml->createElementNS ( 'urn:schemas-microsoft-com:office:excel', 'ExcelWorkbook' );
		$excelworkbook = $root->appendChild ( $excelworkbook );
		// ExcelWorkbook - windowheight
		$windowheight = $this->xml->createElement ( 'WindowHeight' );
		$excelworkbook->appendChild ( $windowheight );
		$windowheight->appendChild ( $this->xml->createTextNode ( '6795' ) );
		// ExcelWorkbook - windowwidth
		$windowwidth = $this->xml->createElement ( 'WindowWidth' );
		$excelworkbook->appendChild ( $windowwidth );
		$windowwidth->appendChild ( $this->xml->createTextNode ( '8460' ) );
		// ExcelWorkbook - WindowTopX
		$windowtopx = $this->xml->createElement ( 'WindowTopX' );
		$excelworkbook->appendChild ( $windowtopx );
		$windowtopx->appendChild ( $this->xml->createTextNode ( '120' ) );
		// ExcelWorkbook - WindowTopY
		$windowtopy = $this->xml->createElement ( 'WindowTopY' );
		$excelworkbook->appendChild ( $windowtopy );
		$windowtopy->appendChild ( $this->xml->createTextNode ( '15' ) );
		// ExcelWorkbook - ProtectStructure
		$protectstructure = $this->xml->createElement ( 'ProtectStructure' );
		$excelworkbook->appendChild ( $protectstructure );
		$protectstructure->appendChild ( $this->xml->createTextNode ( 'False' ) );
		// ExcelWorkbook - ProtectWindows
		$protectwindows = $this->xml->createElement ( 'ProtectWindows' );
		$protectwindows = $excelworkbook->appendChild ( $protectwindows );
		$protectwindows->appendChild ( $this->xml->createTextNode ( 'False' ) );
		
		// Ebene Styles
		$this->xml->styles = $this->xml->createElement ( 'Styles' );
		$root->appendChild ( $this->xml->styles );
		// Styles - Style
		$style = $this->xml->createElement ( 'Style' );
		$style = $this->xml->styles->appendChild ( $style );
		$attr1 = $this->xml->createAttribute ( 'ss:ID' );
		$style->appendChild ( $attr1 );
		$attr1->appendChild ( $this->xml->createTextNode ( "Default" ) );
		$attr2 = $this->xml->createAttribute ( 'ss:Name' );
		$style->appendChild ( $attr2 );
		$attr2->appendChild ( $this->xml->createTextNode ( "Normal" ) );
		// Styles - Style - Alignment
		$alignment = $this->xml->createElement ( 'Alignment' );
		$alignment = $style->appendChild ( $alignment );
		$attr1 = $this->xml->createAttribute ( 'ss:Vertical' );
		$alignment->appendChild ( $attr1 );
		$attr1->appendChild ( $this->xml->createTextNode ( "Bottom" ) );
		// Styles - Style - Borders
		$borders = $this->xml->createElement ( 'Borders' );
		$style->appendChild ( $borders );
		// Styles - Style - Font
		$font = $this->xml->createElement ( 'Font' );
		$style->appendChild ( $font );
		// Styles - Style - Interior
		$interior = $this->xml->createElement ( 'Interior' );
		$style->appendChild ( $interior );
		// Styles - Style - NumberFormat
		$numberformat = $this->xml->createElement ( 'NumberFormat' );
		$style->appendChild ( $numberformat );
		// Styles - Style - Protection
		$protection = $this->xml->createElement ( 'Protection' );
		$style->appendChild ( $protection );
		
		// Ebene Worksheet
		$this->xml->worksheet = $this->xml->createElement ( 'Worksheet' );
		$root->appendChild ( $this->xml->worksheet );
		// Worksheet - Table
		$this->xml->table = $this->xml->createElement ( 'Table' );
		$this->xml->worksheet->appendChild ( $this->xml->table );
		$attr1 = $this->xml->createAttribute ( 'ss:ExpandedColumnCount' );
		$this->xml->table->appendChild ( $attr1 );
		$attr1->appendChild ( $this->xml->createTextNode ( "60000" ) );
		$attr2 = $this->xml->createAttribute ( 'ss:ExpandedRowCount' );
		$this->xml->table->appendChild ( $attr2 );
		$attr2->appendChild ( $this->xml->createTextNode ( "60000" ) );
		$attr3 = $this->xml->createAttribute ( 'x:FullColumns' );
		$this->xml->table->appendChild ( $attr3 );
		$attr3->appendChild ( $this->xml->createTextNode ( "1" ) );
		$attr4 = $this->xml->createAttribute ( 'x:FullRows' );
		$this->xml->table->appendChild ( $attr4 );
		$attr4->appendChild ( $this->xml->createTextNode ( "1" ) );
		$attr5 = $this->xml->createAttribute ( 'ss:Name' );
		$this->xml->worksheet->appendChild ( $attr5 );
		$attr5->appendChild ( $this->xml->createTextNode ( 'Tabelle 1' ) );
		// Worksheet - Table - Row
		$this->xml->row = array ();
		
		// Worksheet-Options
		$options = $this->xml->createElement ( 'WorksheetOptions' );
		$options = $this->xml->worksheet->appendChild ( $options );
		$attr1 = $this->xml->createElement ( 'xmlns' );
		$options->appendChild ( $attr1 );
		$attr1->appendChild ( $this->xml->createTextNode ( 'urn:schemas-microsoft-com:office:excel' ) );
		// Worksheet-Options - Print
		$print = $this->xml->createElement ( 'Print' );
		$options->appendChild ( $print );
		$printerinfo = $this->xml->createElement ( 'ValidPrinterInfo' );
		$print->appendChild ( $printerinfo );
		$hresolution = $this->xml->createElement ( 'HorizontalResolution' );
		$print->appendChild ( $hresolution );
		$hresolution->appendChild ( $this->xml->createTextNode ( '600' ) );
		$vresolution = $this->xml->createElement ( 'VerticalResolution' );
		$print->appendChild ( $vresolution );
		$vresolution->appendChild ( $this->xml->createTextNode ( '600' ) );
		// Worksheet-Options - Selected
		$selected = $this->xml->createElement ( 'Selected' );
		$options->appendChild ( $selected );
		// Worksheet-Options - Panes
		$panes = $this->xml->createElement ( 'Panes' );
		$options->appendChild ( $panes );
		$pane = $this->xml->createElement ( 'Pane' );
		$panes->appendChild ( $pane );
		$number = $this->xml->createElement ( 'Number' );
		$pane->appendChild ( $number );
		$number->appendChild ( $this->xml->createTextNode ( '3' ) );
		$arow = $this->xml->createElement ( 'ActiveRow' );
		$pane->appendChild ( $arow );
		$arow->appendChild ( $this->xml->createTextNode ( '5' ) );
		$acol = $this->xml->createElement ( 'ActiveCol' );
		$pane->appendChild ( $acol );
		$acol->appendChild ( $this->xml->createTextNode ( '1' ) );
		// Worksheet-Options - ProtectObjects
		$protect_objects = $this->xml->createElement ( 'ProtectObjects' );
		$options->appendChild ( $protect_objects );
		$protect_objects->appendChild ( $this->xml->createTextNode ( 'False' ) );
		// Worksheet-Options - ProtectScenarios
		$protect_scenarios = $this->xml->createElement ( 'ProtectScenarios' );
		$options->appendChild ( $protect_scenarios );
		$protect_scenarios->appendChild ( $this->xml->createTextNode ( 'False' ) );
		
		$this->xml->normalizeDocument ();
	}
	
	/**
	 * Worksheet-Namen setzen
	 *
	 * Beispiel:
	 * setWorksheetName( 'Busaufträge' );
	 *
	 * erzeugt die XML-Ausgabe:
	 * <Worksheet ss:Name="Busauftraege">
	 * ...
	 * </Worksheet>
	 *
	 * @param string $name
	 *        	des Worksheets
	 */
	public function setWorksheetName($name) {
		$attr = $this->xml->createAttribute ( 'ss:Name' );
		$this->xml->worksheet->appendChild ( $attr );
		$attr->appendChild ( $this->xml->createTextNode ( $name ) );
	}
	
	/**
	 * Funktion, um Style-Definitionen zu erstellen.
	 *
	 * Beispiel:
	 * createStyle( 'ueberschrift', 'Font', 'ss:Bold', '1' );
	 *
	 * erzeugt die XML-Ausgabe:
	 * <Style ss:ID="ueberschrift">
	 * <Font ss:Bold="1" />
	 * </Style>
	 *
	 * @param string $name
	 *        	des Styles
	 * @param string $art
	 *        	der Definition (Font, Color, ...)
	 * @param string $typ
	 *        	des Styles
	 * @param string $wert
	 *        	der Excel-XML-Definition
	 */
	public function createStyle($name, $art, $typ, $wert) {
		$style = $this->xml->createElement ( 'Style' );
		$style = $this->xml->styles->appendChild ( $style );
		$attr1 = $this->xml->createAttribute ( 'ss:ID' );
		$style->appendChild ( $attr1 );
		$attr1->appendChild ( $this->xml->createTextNode ( $name ) );
		
		$auspraegung = $this->xml->createElement ( $art );
		$style->appendChild ( $auspraegung );
		$attr2 = $this->xml->createAttribute ( $typ );
		$auspraegung->appendChild ( $attr2 );
		$attr2->appendChild ( $this->xml->createTextNode ( $wert ) );
	}
	
	/**
	 * Eine neue Excel-Zeile im XML-Dokument einfügen
	 *
	 * Beispiel:
	 * addRow(3);
	 *
	 * erzeugt die XML-Ausgabe:
	 * <Row ss:Index="3">
	 * ...
	 * </Row>
	 *
	 * @param int $zeile        	
	 */
	public function addRow($zeile) {
		$this->xml->row [$zeile] = $this->xml->createElement ( 'Row' );
		$attr = $this->xml->createAttribute ( 'ss:Index' );
		$this->xml->row [$zeile]->appendChild ( $attr );
		$attr->appendChild ( $this->xml->createTextNode ( $zeile ) );
		$this->xml->row [$zeile] = $this->xml->table->appendChild ( $this->xml->row [$zeile] );
	}
	
	/**
	 * Daten in eine Zelle schreiben
	 *
	 * Beispiel:
	 * writeData('22:20:52',3,10,"1899-12-31T",'','uhrzeit','DateTime');
	 *
	 * erzeugt die XML-Ausgabe für Zeile 3:
	 * <Cell ss:Index="10" ss:StyleID="uhrzeit">
	 * <Data ss:Type="DateTime">1899-12-31T22:20:52</Data>
	 * </Cell>
	 *
	 * @param string $input
	 *        	der Zelle
	 * @param int $zeile        	
	 * @param int $spalte        	
	 * @param string $prefix
	 *        	für den Zelleninhalt
	 * @param string $suffix
	 *        	für den Zelleninhalt
	 * @param string $style_id
	 *        	des Styles, der für die Zelle genutzt werden soll
	 * @param string $style_type
	 *        	der Zelle (String, DateTime, ...)
	 */
	public function writeData($input, $zeile, $spalte, $prefix = '', $suffix = '', $style_id = '', $style_type = 'String') {
		// Wenn die entsprechende Zeile noch nicht angelegt wurde, dies nachholen
		if (! isset ( $this->xml->row [$zeile] )) {
			self::addRow ( $zeile );
		}
		
		// Zelle anlegen
		$cell = $this->xml->createElement ( 'Cell' );
		$cell = $this->xml->row [$zeile]->appendChild ( $cell );
		
		if ($spalte != '') {
			$attr1 = $this->xml->createAttribute ( 'ss:Index' );
			$cell->appendChild ( $attr1 );
			$attr1->appendChild ( $this->xml->createTextNode ( $spalte ) );
		}
		
		if ($style_id != '') {
			$attr2 = $this->xml->createAttribute ( 'ss:StyleID' );
			$cell->appendChild ( $attr2 );
			$attr2->appendChild ( $this->xml->createTextNode ( $style_id ) );
		}
		
		$data = $this->xml->createElement ( 'Data' );
		$data = $cell->appendChild ( $data );
		$attr3 = $this->xml->createAttribute ( 'ss:Type' );
		$data->appendChild ( $attr3 );
		$attr3->appendChild ( $this->xml->createTextNode ( $style_type ) );
		$data->appendChild ( $this->xml->createTextNode ( $prefix . $input . $suffix ) );
	}
	
	/**
	 * Diese Funktion schreibt eine Formel in eine Zelle.
	 *
	 * Die Formel muss in relativer Notation geschrieben sein, d.h. absolute Zellbezeichnungen wie A3, C2, etc.
	 * sind nicht nutzbar. Stattdessen verweist man auf die Zellen in relativer Entfernung zur Formelzelle. Die
	 * Summe der drei Zellen über der aktuellen wird somit zu "=SUM(R[-3]C:R[-1]C)". Ergänzung um die drei Zellen
	 * in der Spalte nebenan: "=SUM(R[-3]C:R[-1]C[1]".
	 *
	 * Beispiel:
	 * writeFormula('=SUM(R[-3]C:R[-1]C[1])',3,10,'ueberschrift');
	 *
	 * erzeugt die XML-Ausgabe für Zeile 3:
	 * <Cell ss:Index="10" ss:StyleID="ueberschrift" ss:Formula="=SUM(R[-3]C:R[-1]C[1])">
	 * <Data ss:Type="Number"></Data>
	 * </Cell>
	 *
	 * @param string $formel
	 *        	in relativer Notation
	 * @param int $zeile        	
	 * @param int $spalte        	
	 * @param string $style_id
	 *        	des Styles, der für die Zelle genutzt werden soll
	 */
	public function writeFormula($formel, $zeile, $spalte, $style_id = '') {
		// Wenn die entsprechende Zeile noch nicht angelegt wurde, dies nachholen
		if (! isset ( $this->xml->row [$zeile] )) {
			self::addRow ( $zeile );
		}
		
		// Zelle anlegen
		$cell = $this->xml->createElement ( 'Cell' );
		$cell = $this->xml->row [$zeile]->appendChild ( $cell );
		
		if ($spalte != '') {
			$attr1 = $this->xml->createAttribute ( 'ss:Index' );
			$cell->appendChild ( $attr1 );
			$attr1->appendChild ( $this->xml->createTextNode ( $spalte ) );
		}
		
		if ($style_id != '') {
			$attr2 = $this->xml->createAttribute ( 'ss:StyleID' );
			$cell->appendChild ( $attr2 );
			$attr2->appendChild ( $this->xml->createTextNode ( $style_id ) );
		}
		
		$attr3 = $this->xml->createAttribute ( 'ss:Formula' );
		$cell->appendChild ( $attr3 );
		$attr3->appendChild ( $this->xml->createTextNode ( $formel ) );
		
		$data = $this->xml->createElement ( 'Data' );
		$cell->appendChild ( $data );
		$attr3 = $this->xml->createAttribute ( 'ss:Type' );
		$data->appendChild ( $attr3 );
		$attr3->appendChild ( $this->xml->createTextNode ( 'Number' ) );
		$data->appendChild ( $this->xml->createTextNode ( '' ) ); // Leerer Inhalt (wird ja von Excel berechnet)
	}
	
	/**
	 * Diese Funktion gibt die endgültige XML-Datei zurück
	 *
	 * @return $file
	 */
	public function getFile() {
		return $this->xml->saveXML ();
	}
}

?>
