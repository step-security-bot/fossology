/*
 SPDX-FileCopyrightText: © 2020 Siemens AG

 SPDX-License-Identifier: GPL-2.0-only
*/
/**
 * @file
 */
#ifndef SRC_COMPATIBILITY_AGENT_COMPATIBILITYAGENT_HPP_
#define SRC_COMPATIBILITY_AGENT_COMPATIBILITYAGENT_HPP_

#include <fstream>
#include <vector>
#include <string>
#include <iostream>
#include <tuple>

#include "CompatibilityDatabaseHandler.hpp"

/**
 * @class CompatibilityAgent
 * The CompatibilityAgent class with various functions to scan a file.
 */
class CompatibilityAgent
{
  public:
    CompatibilityAgent(int agentId, bool verbosityDebug);
    bool checkCompatibilityForPfile(vector<unsigned long> &licId, unsigned long &pFileId,
                                    CompatibilityDatabaseHandler &databaseHandler) const;
  private:
    int agentId;
    bool verbosityDebug;
};

#endif /* SRC_COMPATIBILITY_AGENT_COMPATIBILITYAGENT_HPP_ */
