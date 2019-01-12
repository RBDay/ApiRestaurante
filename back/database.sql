-- Para comprobar que todas las relaciones estan correctas una vez importada la BD ejecutar esta query

SELECT platos.Nombre_plato,ingredientes.Nombre_ingrediente,alergenos.Nombre_alergeno FROM `platos`
		RIGHT JOIN platosingredientes ON platos.ID_plato = platosingredientes.ID_plato
		RIGHT JOIN ingredientes ON platosingredientes.ID_ingrediente = ingredientes.ID_ingrediente
		RIGHT JOIN ingredientesalergenos ON ingredientes.ID_ingrediente = ingredientesalergenos.ID_ingrediente
		RIGHT JOIN alergenos ON ingredientesalergenos.ID_alergeno = alergenos.ID_alergeno

-- Importación ---------------------------------------------------------------------------------------------
-- IMPORTACIÖN A PARTIR DE AQUÍ ----------------------------------------------------------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `platostest`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alergenos`
--

CREATE TABLE `alergenos` (
  `ID_alergeno` int(11) NOT NULL,
  `Nombre_alergeno` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `alergenos`
--

INSERT INTO `alergenos` (`ID_alergeno`, `Nombre_alergeno`) VALUES
(1, 'Marisco'),
(2, 'Frutos secos'),
(3, 'Lacteos'),
(4, 'Pescado'),
(5, 'Picante'),
(6, 'Trigo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `ID_ingrediente` int(11) NOT NULL,
  `Nombre_ingrediente` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`ID_ingrediente`, `Nombre_ingrediente`) VALUES
(1, 'Sardina'),
(2, 'Guindilla'),
(3, 'Ternera'),
(4, 'Gambas'),
(5, 'Coliflor'),
(6, 'Cerveza de cocina'),
(7, 'Nata'),
(8, 'Anchoas'),
(9, 'Bogavante'),
(10, 'Aceite'),
(11, 'Jarabe para la tos'),
(12, 'Pollo'),
(13, 'Macarrones'),
(14, 'Espaguetis');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientesalergenos`
--

CREATE TABLE `ingredientesalergenos` (
  `ID_ingrediente` int(11) NOT NULL,
  `ID_alergeno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ingredientesalergenos`
--

INSERT INTO `ingredientesalergenos` (`ID_ingrediente`, `ID_alergeno`) VALUES
(1, 4),
(2, 5),
(4, 1),
(6, 6),
(7, 3),
(8, 4),
(9, 1),
(13, 6),
(14, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos`
--

CREATE TABLE `platos` (
  `ID_plato` int(11) NOT NULL,
  `Nombre_plato` varchar(300) NOT NULL,
  `Descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `platos`
--

INSERT INTO `platos` (`ID_plato`, `Nombre_plato`, `Descripcion`) VALUES
(1, 'Sardinas a la nata', 'Este delicioso plato esta preparado horneando las sardinas junto a medio litro de nata casera.\r\n\r\nPor si esto no fuera suficiente, el chef ha especiado el resultado con un poco de hierbas provenzales y sal.\r\n\r\n¡Atrévase a degustar esta increíble mezcla de la tierra y el mar!'),
(2, 'Ternera con ensalada de pasta', 'Del puro interior nace esta receta irresistible que conquista el paladar con la fuerza de la carne roja y el encanto y la sutileza de la pasta al dente.\r\n\r\nLa fusión de estos dos elementos te sorprenderá en cuanto a textura y jugosidad. ¡No te la pierdas!'),
(3, 'Coliflor con guindillas', 'Siempre se ha hablado de que la coliflor es un plato al gusto de unos pocos. Nuestro chef se propone demostrarte que no es así con esta nueva creación.\r\n\r\nLa coliflor esta servida en una fuente con deliciosa salsa de guindillas. Convirtiendo un plato digno de la tercera edad en un paseo a urgencias por quemaduras de tercer grado.\r\n\r\n¿Te atreves a probarlo?'),
(4, 'Espaguetis con anchoas en su aceite', 'Si miramos al pasado nos encontraremos con que siempre nos hemos hecho la pasta acompañada de salsas creadas hace siglos. Recetas harto conocidas y que ya nadie redescubre.\r\n\r\nPero eso esta a punto de cambiar con la nueva presentación de este ingenioso chef. ¿Acaso no hay una receta que no pueda sorprendernos?\r\n\r\nEn este plato nos presentará un excelente plato de pasta con su nueva salsa venida del fondo del mar.\r\n\r\n¡Íncale el diente!');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platosingredientes`
--

CREATE TABLE `platosingredientes` (
  `ID_plato` int(11) NOT NULL,
  `ID_ingrediente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `platosingredientes`
--

INSERT INTO `platosingredientes` (`ID_plato`, `ID_ingrediente`) VALUES
(1, 1),
(1, 7),
(2, 3),
(2, 13),
(3, 5),
(3, 2),
(4, 14),
(4, 8),
(4, 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alergenos`
--
ALTER TABLE `alergenos`
  ADD PRIMARY KEY (`ID_alergeno`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`ID_ingrediente`);

--
-- Indices de la tabla `platos`
--
ALTER TABLE `platos`
  ADD PRIMARY KEY (`ID_plato`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alergenos`
--
ALTER TABLE `alergenos`
  MODIFY `ID_alergeno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `ID_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `platos`
--
ALTER TABLE `platos`
  MODIFY `ID_plato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;
