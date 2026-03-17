Component Class
===============

.. php:namespace:: BeastBytes\Yii\Leaflet

.. php:class:: Component

    A component of a Leaflet map

    This class is for use by plugin developers; all plugins *must* extend this class

    .. php:method:: __construct(array $options)

        Create a new component

        :param array<string, mixed>. $options: Component options
        :returns: A new `Component` instance
        :rtype: Component

    .. php:method:: addToMap(bool $addToMap): self

        Determine whether the component is added to the map

        The default is to add the component to the map

        :param bool $addToMap: Whether to add the component to the map
        :return: A new `Component` instance with addToMap
        :rtype: Component

    .. php:method:: jsVar(string $jsVar)

        Set the component's JavaScript variable name

        :param string $jsVar: The component's JavaScript variable name
        :return: A new `Component` instance with the component's JavaScript variable name
        :rtype: Component

    .. php:method:: getJsVar()

        Get the component's JavaScript variable name

        If :php:meth:`jsVar` has not been called a variable name of the form `\\w+\\d+` will be generated, where:

        * `\\w+` is the type of component - 'control' || 'layer' || 'plugin'
        * `\\d+` is a unique number for the component type

        Example: `control1`

        :return: The component's JavaScript variable name
        :rtype: string
