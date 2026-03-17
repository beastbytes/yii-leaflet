Inherited from Component
------------------------

    .. php:method:: addToMap(bool $addToMap)

        Whether to add the component to the map

        By default, a component is added to the map.

        :param bool $addToMap: Whether the component is added to the map
        :returns: A new instance of |component| with the `addToMap` parameter set
        :rtype: |component|

    .. php:method:: getJsVar()

        Returns the JavaScript variable name

        :returns: The JavaScript variable name
        :rtype: string

    .. php:method:: jsVar(string $jsVar)

        Set the JavaScript variable name

        :param string $jsVar: The JavaScript variable name
        :returns: A new instance of |component| with the JavaScript variable name set
        :rtype: |component|
