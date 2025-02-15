-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 15, 2025 at 10:10 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cukierki`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `Nazwisko` varchar(15) DEFAULT NULL,
  `Imie` varchar(13) DEFAULT NULL,
  `Ulica` varchar(24) DEFAULT NULL,
  `Miasto` varchar(15) DEFAULT NULL,
  `KodPocztowy` varchar(7) DEFAULT NULL,
  `Kraj` varchar(15) DEFAULT NULL,
  `Telefon` varchar(18) DEFAULT NULL,
  `haslo` varchar(40) DEFAULT NULL,
  `NumerKlienta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pudelka`
--

CREATE TABLE `pudelka` (
  `IdPudelka` varchar(4) NOT NULL,
  `NazwaPudelka` varchar(27) DEFAULT NULL,
  `Opis` varchar(145) DEFAULT NULL,
  `Cena` varchar(5) DEFAULT NULL,
  `url` varchar(210) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pudelka`
--

INSERT INTO `pudelka` (`IdPudelka`, `NazwaPudelka`, `Opis`, `Cena`, `url`) VALUES
('ALPY', 'Alpejska Rozkosz', 'Zanurz się w wyjątkowym smaku alpejskich owoców, które dojrzewają w czystym, górskim powietrzu. Soczyste jagody i truskawki, połączone z najlepsz', '20,75', 'https://images.unsplash.com/photo-1603202902092-3eb7a76ecf5f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHwxfHxjYW5kaWVzfGVufDB8fHx8MTY5NjcwMjk3Mnww&ixlib=rb-4.0.3&q=80&w=200'),
('DELI', 'Orzechowa Delicja', 'Gładkie, aksamitne masło orzechowe otulone warstwą najwyższej jakości czekolady to propozycja dla prawdziwych smakoszy. Każdy kęs to doskonałe po', '19,00', 'https://images.unsplash.com/photo-1582058091505-f87a2e55a40f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHwyfHxjYW5kaWVzfGVufDB8fHx8MTY5NjcwMjk3Mnww&ixlib=rb-4.0.3&q=80&w=200'),
('FANT', 'Mokka Fantazja', 'Dla miłośników kawy i czekolady - nasze słynne nadzienie mokka skrywa się pod warstwą delikatnej czekolady. Intensywny aromat kawy przeniesie Cię', '18,00', 'https://images.unsplash.com/photo-1575224300306-1b8da36134ec?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHwzfHxjYW5kaWVzfGVufDB8fHx8MTY5NjcwMjk3Mnww&ixlib=rb-4.0.3&q=80&w=200'),
('GORZ', 'Czekoladowa Harmonia', 'Gorzka czekolada o intensywnym smaku w połączeniu z wyselekcjonowanymi owocami - soczystymi truskawkami, wiśniami, jagodami i malinami. Całość do', '27,75', 'https://images.unsplash.com/photo-1601493701002-3223e7e1ebaf?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHw0fHxjYW5kaWVzfGVufDB8fHx8MTY5NjcwMjk3Mnww&ixlib=rb-4.0.3&q=80&w=200'),
('INTE', 'Smaki Świata', 'Podróżuj po kulinarnych zakątkach świata...', '34,00', 'https://images.unsplash.com/photo-1514517521153-1be72277b32f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHw1fHxjYW5kaWVzfGVufDB8fHx8MTY5NjcwMjk3Mnww&ixlib=rb-4.0.3&q=80&w=200'),
('KREM', 'Kremowa Pokusa', 'Gładkie, puszyste nadzienie w trzech wariantach...', '23,00', 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHw2fHxjYW5kaWVzfGVufDB8fHx8MTY5NjcwMjk3Mnww&ixlib=rb-4.0.3&q=80&w=200'),
('MARC', 'Marcepanowa Uczta', 'Daj się porwać bogatemu smakowi marcepanu...', '32,25', 'https://images.unsplash.com/photo-1606797020447-cf605fc9e408?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHw3fHxjYW5kaWVzfGVufDB8fHx8MTY5NjcwMjk3Mnww&ixlib=rb-4.0.3&q=80&w=200'),
('NIEZ', 'Laskowy Raj', 'Starannie dobrana selekcja orzechów laskowych w różnych odsłonach - delikatne, prażone, aromatyczne mokka, wyraziste Amaretto oraz nuty gorzkiej ', '15,75', 'https://images.unsplash.com/photo-1600359756098-8bc52195bbf4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHw4fHxjYW5kaWVzfGVufDB8fHx8MTY5NjcwMjk3Mnww&ixlib=rb-4.0.3&q=80&w=200'),
('PACY', 'Skarby Oceanu', 'Bogactwo smaków zamknięte w jednej kolekcji. Migdałowa Ambrozja, Orzech Laskowy Mokka oraz Marcepanowy Słowik to wyjątkowe kompozycje, które zabi', '21,00', 'https://images.unsplash.com/photo-1581798269145-7512508289b9?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHw5fHxjYW5kaWVzfGVufDB8fHx8MTY5NjcwMjk3Mnww&ixlib=rb-4.0.3&q=80&w=200'),
('POLN', 'Północne Inspiracje', 'Idealny zestaw dla romantyków i marzycieli. Znajdziesz tu wyjątkowe praliny inspirowane północnym klimatem: Marcepanowa Jaskółka, Marcepanowy Sło', '33,25', 'https://images.unsplash.com/photo-1571506165871-ee72a35bc9d4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHwxMHx8Y2FuZGllc3xlbnwwfHx8fDE2OTY3MDI5NzJ8MA&ixlib=rb-4.0.3&q=80&w=200'),
('SERC', 'Serce Miłości', 'Kolekcja czekoladowych serc, w której każda pralina ma swoją historię: Złamane Serce, Serce Kochanka oraz Serce w Plecaku. Wyjątkowe połączenia b', '17,50', 'https://images.unsplash.com/photo-1598188080888-42dfffa02287?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHwxMXx8Y2FuZGllc3xlbnwwfHx8fDE2OTY3MDMzMTJ8MA&ixlib=rb-4.0.3&q=80&w=200'),
('SGOR', 'Owocowa Gorzkość', 'Dla tych, którzy kochają kontrasty - nasza unikalna mieszanka jagód, wiśni, marmolady, malin i truskawek, zamknięta w gorzkiej czekoladzie. Słody', '27,75', 'https://images.unsplash.com/photo-1519087318609-bfb5c04c27f5?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHwxMnx8Y2FuZGllc3xlbnwwfHx8fDE2OTY3MDMzMTJ8MA&ixlib=rb-4.0.3&q=80&w=200'),
('SUPR', 'Mistrzowska Kompozycja', 'Perfekcyjne połączenie dwóch wyjątkowych kolekcji - delikatesowego wyboru pralinek oraz najlepszych słodyczy z orzechami laskowymi. Każdy kęs to ', '18,25', 'https://images.unsplash.com/photo-1610961138779-2433f6fd227a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHwxM3x8Y2FuZGllc3xlbnwwfHx8fDE2OTY3MDMzMTJ8MA&ixlib=rb-4.0.3&q=80&w=200'),
('WISN', 'Wiśniowa Klasyka', 'Klasyczne wiśnie w najlepszym wydaniu - słodkie, słodko-gorzkie oraz klasyczne. Każda z nich zanurzona w aksamitnej czekoladzie, która podkreśla ', '16,25', 'https://images.unsplash.com/photo-1576025916944-438d601fc0bf?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHwxNHx8Y2FuZGllc3xlbnwwfHx8fDE2OTY3MDMzMTJ8MA&ixlib=rb-4.0.3&q=80&w=200'),
('WYSP', 'Egzotyczna Kolekcja', 'Zanurz się w smakach tropikalnych wysp dzięki naszej unikalnej kompozycji. Czekoladowe Kiwi, Palma Tropikalna oraz Marcepanowa Jaskółka to egzoty', '35,00', 'https://images.unsplash.com/photo-1533602933119-70608e48905d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNTM1ODF8MHwxfHNlYXJjaHwxNXx8Y2FuZGllc3xlbnwwfHx8fDE2OTY3MDMzMTJ8MA&ixlib=rb-4.0.3&q=80&w=200');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegoly_zamowien`
--

CREATE TABLE `szczegoly_zamowien` (
  `NumerZamowienia` int(3) DEFAULT NULL,
  `IdPudelka` varchar(4) DEFAULT NULL,
  `Ilosc` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `NumerZamowienia` int(3) NOT NULL,
  `NumerKlienta` int(11) DEFAULT NULL,
  `DataZamowienia` date DEFAULT NULL,
  `NazwiskoOdbiorcy` varchar(14) DEFAULT NULL,
  `ImieOdbiorcy` varchar(11) DEFAULT NULL,
  `UlicaOdbiorcy` varchar(27) DEFAULT NULL,
  `MiastoOdbiorcy` varchar(23) DEFAULT NULL,
  `KodPocztowyOdbiorcy` varchar(7) DEFAULT NULL,
  `KrajOdbiorcy` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`NumerKlienta`);

--
-- Indeksy dla tabeli `pudelka`
--
ALTER TABLE `pudelka`
  ADD PRIMARY KEY (`IdPudelka`);

--
-- Indeksy dla tabeli `szczegoly_zamowien`
--
ALTER TABLE `szczegoly_zamowien`
  ADD KEY `NumerZamowienia` (`NumerZamowienia`),
  ADD KEY `KodPudelka` (`IdPudelka`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`NumerZamowienia`),
  ADD KEY `NumerKlienta` (`NumerKlienta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klienci`
--
ALTER TABLE `klienci`
  MODIFY `NumerKlienta` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `szczegoly_zamowien`
--
ALTER TABLE `szczegoly_zamowien`
  ADD CONSTRAINT `szczegoly_zamowien_ibfk_1` FOREIGN KEY (`NumerZamowienia`) REFERENCES `zamowienia` (`NumerZamowienia`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `szczegoly_zamowien_ibfk_2` FOREIGN KEY (`IdPudelka`) REFERENCES `pudelka` (`IdPudelka`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`NumerKlienta`) REFERENCES `klienci` (`NumerKlienta`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
