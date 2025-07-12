<?php
    namespace Application\model\fpdf;

    class FacturaPdf extends Fpdf
    {
       public string $title;

        public function header()
        {
            $this->Image(SITE_ROOT . "/images/main_logo.png", 10, 8, 33);            
            $this->AddFont("GreatVibes", "", "GreatVibes-Regular.php");
            $this->SetFont('GreatVibes','',25); 
            $this->Ln(20);
            $this->Cell(0, 10, $this->title, 0, 0, 'C');
            $this->Ln(20);
        }

        public function footer()
        { 
            /** 3cm del final */
            $this->SetY(-30);

            global $total;
        
            $this->SetFont('GreatVibes','',15);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(60, 10, 'Total', 0, 0, 'L', true);            
            $this->Cell(30, 10, number_format(floatval($total), 2, ',', '.') . " " . EURO_SIMBOL, 0, 0, 'R', true);

            /** 1,5cm del final */
            $this->SetY(-15);

            $this->SetTextColor(0, 0, 0);
            $this->SetFont('Arial','I',8);

            /** Número de página */
            $this->Cell(0,10,iconv('UTF-8', 'ISO-8859-1', 'Página ') .$this->PageNo()." de {nb}",0,0,"C");
        }
    }
    
?>